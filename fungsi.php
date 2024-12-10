<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit;
}

function koneksiDB()
{
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'peminjaman';

  $koneksi = new mysqli($host, $user, $password, $database);

  if ($koneksi->connect_error) {
    die('Koneksi database gagal: ' . $koneksi->connect_error);
  }
  return $koneksi;
}

function validasiLogin($username, $password)
{
  $conn = koneksiDB();

  $stmt = $conn->prepare("SELECT username, password, level FROM tb_user WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

      return [
        'status' => true,
        'data' => [
          'username' => $user['username'],
          'level' => $user['level']
        ]
      ];
    } else {
      return ['status' => false, 'message' => 'Password salah.'];
    }
  } else {
    return ['status' => false, 'message' => 'Username tidak ditemukan.'];
  }
}

function isUsernameExists($username)
{
  $conn = koneksiDB();
  $sql = "SELECT COUNT(*) as count FROM tb_user WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row['count'] > 0;
}

function createUser($username, $fullname, $password, $level)
{
  $conn = koneksiDB();
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO tb_user (username, fullname, password, level) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $username, $fullname, $hashedPassword, $level);

  if ($stmt->execute()) {
    logAktivitas($_SESSION['username'], 'create_user', "User baru dibuat: $fullname");
    return true;
  } else {
    error_log("Error saat membuat user: " . $stmt->error);
    return false;
  }
}

function getUsers()
{
  $conn = koneksiDB();
  $sql = "SELECT * FROM tb_user";
  $result = $conn->query($sql);
  return $result->fetch_all(MYSQLI_ASSOC);
}

function getUserByUsername($username)
{
  $conn = koneksiDB();
  $sql = "SELECT * FROM tb_user WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}

function updateUser($username, $fullname, $password, $level)
{
  $conn = koneksiDB();
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $sql = "UPDATE tb_user SET fullname = ?, password = ?, level = ? WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $fullname, $hashedPassword, $level, $username);

  if ($stmt->execute()) {
    logAktivitas($_SESSION['username'], 'update_user', "User $fullname telah diperbarui");
    return true;
  } else {
    error_log("Error saat memperbarui user: " . $stmt->error);
    return false;
  }
}

if (isset($_GET['delete_user'])) {
  $conn = koneksiDB();
  $id = $_GET['username'];
  $sql = "DELETE FROM tb_user WHERE username='$id'";
  if ($conn->query($sql) === TRUE) {
    logAktivitas($_SESSION['username'], 'delete_user', "User $id telah dihapus");
    echo "User berhasil dihapus.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function createPeminjaman($id_peminjaman, $id_ruangan, $username, $waktu_pengajuan, $status_pinjam, $keterangan)
{
  $conn = koneksiDB();
  $sql = "INSERT INTO tb_peminjaman (id_ruangan, username, waktu_pengajuan, status_pinjam, keterangan) 
            VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $id_ruangan, $username, $waktu_pengajuan, $status_pinjam, $keterangan);

  if ($stmt->execute()) {
    logAktivitas($_SESSION['username'], 'create_peminjaman', "Peminjaman baru dibuat untuk ruangan: $id_ruangan");
    return true;
  } else {
    error_log("Error saat membuat peminjaman: " . $stmt->error);
    return false;
  }
}

function getPeminjaman()
{
  $conn = koneksiDB();
  $sql = "SELECT p.id_peminjaman, r.nama_ruangan, p.username, p.waktu_pengajuan, p.status_pinjam, p.keterangan
            FROM tb_peminjaman p
            JOIN tb_ruangan r ON p.id_ruangan = r.id_ruangan";
  $result = $conn->query($sql);
  return $result->fetch_all(MYSQLI_ASSOC);
}

function getPeminjamanById($id)
{
  $conn = koneksiDB();
  $sql = "SELECT * FROM tb_peminjaman WHERE id_peminjaman = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}

function getUsernames()
{
  $conn = koneksiDB();
  $sql = "SELECT username FROM tb_user";
  $result = $conn->query($sql);
  $usernames = [];

  while ($row = $result->fetch_assoc()) {
    $usernames[] = $row['username'];
  }

  return $usernames;
}

function updatePeminjaman($id_peminjaman, $id_ruangan, $username, $waktu_pengajuan, $status_pinjam, $keterangan)
{
  $conn = koneksiDB();
  $sql = "UPDATE tb_peminjaman 
          SET id_ruangan = ?, username = ?, waktu_pengajuan = ?, status_pinjam = ?, keterangan = ? 
          WHERE id_peminjaman = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssi", $id_ruangan, $username, $waktu_pengajuan, $status_pinjam, $keterangan, $id_peminjaman);

  if ($stmt->execute()) {
    logAktivitas($_SESSION['username'], 'update_peminjaman', "Peminjaman telah diupdate untuk ruangan: $id_ruangan");
    return true;
  } else {
    error_log("Error saat update peminjaman: " . $stmt->error);
    return false;
  }
}

if (isset($_GET['delete_peminjaman'])) {
  $conn = koneksiDB();
  $id = $_GET['id'];
  $sql = "DELETE FROM tb_peminjaman WHERE id_peminjaman='$id'";
  if ($conn->query($sql) === TRUE) {
    logAktivitas($_SESSION['username'], 'delete_peminjaman', "Peminjaman $id telah dihapus");
    echo "Data Ruangan berhasil dihapus.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function createRuangan($id_ruangan, $nama_ruangan, $status)
{
  $conn = koneksiDB();
  $sql = "INSERT INTO tb_ruangan (id_ruangan, nama_ruangan, status) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $id_ruangan, $nama_ruangan, $status);

  if ($stmt->execute()) {
    logAktivitas($_SESSION['username'], 'create_ruangan', "Ruangan baru ditambahkan: $nama_ruangan");
    return true;
  } else {
    error_log("Error saat menambahkan ruangan: " . $stmt->error);
    return false;
  }
}

function getRuangan()
{
  $conn = koneksiDB();
  $sql = "SELECT * FROM tb_ruangan";
  $result = $conn->query($sql);
  return $result->fetch_all(MYSQLI_ASSOC);
}

function getRuanganById($id)
{
  $conn = koneksiDB();
  $sql = "SELECT * FROM tb_ruangan WHERE id_ruangan = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}

function isNamaRuanganExists($nama_ruangan)
{
  $conn = koneksiDB();
  $sql = "SELECT COUNT(*) AS jumlah FROM tb_ruangan WHERE nama_ruangan = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $nama_ruangan);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
  return $data['jumlah'] > 0;
}


function updateRuangan($id_ruangan, $nama_ruangan, $status)
{
  $conn = koneksiDB();
  $sql = "UPDATE tb_ruangan SET nama_ruangan = ?, status = ? WHERE id_ruangan = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $nama_ruangan, $status, $id_ruangan);

  if ($stmt->execute()) {
    logAktivitas($_SESSION['username'], 'update_ruangan', "Ruangan $nama_ruangan telah diperbarui");
    return true;
  } else {
    error_log("Error saat memperbarui ruangan: " . $stmt->error);
    return false;
  }
}

if (isset($_GET['delete_ruangan'])) {
  $conn = koneksiDB();
  $id = $_GET['id_ruangan'];
  $sql = "DELETE FROM tb_ruangan WHERE id_ruangan='$id'";
  if ($conn->query($sql) === TRUE) {
    logAktivitas($_SESSION['username'], 'delete_ruangan', "Ruangan $id telah dihapus");
    echo "Data Ruangan berhasil dihapus.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function logAktivitas($pengguna, $jenis_aktivitas, $keterangan)
{
  $conn = koneksiDB();
  $sql = "INSERT INTO tb_aktivitas (pengguna, jenis_aktivitas, keterangan) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $pengguna, $jenis_aktivitas, $keterangan);
  return $stmt->execute();
}

function getAllAktivitas()
{
  $conn = koneksiDB();
  $sql = "SELECT * FROM tb_aktivitas ORDER BY waktu DESC";
  $result = $conn->query($sql);
  return $result->fetch_all(MYSQLI_ASSOC);
}

function getDetailPeminjaman($id_peminjaman)
{
  $conn = koneksiDB(); // Pastikan $koneksi sudah terhubung ke database

  $query = "SELECT * FROM tb_detail_peminjaman WHERE id_peminjaman = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id_peminjaman);
  $stmt->execute();
  $result = $stmt->get_result();

  $details = [];
  while ($row = $result->fetch_assoc()) {
    $details[] = $row;
  }

  $stmt->close();
  return $details;
}

function getDetailById($id_detail)
{
  $conn = koneksiDB();

  $stmt = $conn->prepare("SELECT * FROM tb_detail_peminjaman WHERE id_detail_peminjaman = ?");
  $stmt->bind_param("i", $id_detail);
  $stmt->execute();
  $result = $stmt->get_result();

  $detail = $result->fetch_assoc();

  $stmt->close();

  return $detail;
}

function insertDetailPeminjaman($data)
{
  $conn = koneksiDB();

  $stmt = $conn->prepare("INSERT INTO tb_detail_peminjaman (id_peminjaman, tanggal_pinjam, tanggal_pengembalian, kondisi_kelas_awal, status, kondisi_kelas_pengembalian, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param(
    "issssss",
    $data['id_peminjaman'],
    $data['tanggal_pinjam'],
    $data['tanggal_pengembalian'],
    $data['kondisi_kelas_awal'],
    $data['status'],
    $data['kondisi_kelas_pengembalian'],
    $data['keterangan']
  );
  $stmt->execute();

  $stmt->close();
}

function updateDetailPeminjaman($id_detail, $data)
{
  $conn = koneksiDB();

  $stmt = $conn->prepare("UPDATE tb_detail_peminjaman SET tanggal_pinjam = ?, tanggal_pengembalian = ?, kondisi_kelas_awal = ?, status = ?, kondisi_kelas_pengembalian = ?, keterangan = ? WHERE id_detail_peminjaman = ?");
  $stmt->bind_param(
    "ssssssi",
    $data['tanggal_pinjam'],
    $data['tanggal_pengembalian'],
    $data['kondisi_kelas_awal'],
    $data['status'],
    $data['kondisi_kelas_pengembalian'],
    $data['keterangan'],
    $id_detail
  );
  $stmt->execute();

  $stmt->close();
}
