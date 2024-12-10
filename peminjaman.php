<?php
include 'fungsi.php';

$id_peminjaman = $id_ruangan = $username = $waktu_pengajuan = $status_pinjam = $keterangan = "";
$action = 'create';
$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id_peminjaman = isset($_POST['id_peminjaman']) ? htmlspecialchars(trim($_POST['id_peminjaman'])) : '';
  $id_ruangan = isset($_POST['id_ruangan']) ? htmlspecialchars(trim($_POST['id_ruangan'])) : '';
  $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
  $waktu_pengajuan = isset($_POST['waktu_pengajuan']) ? htmlspecialchars(trim($_POST['waktu_pengajuan'])) : '';
  $status_pinjam = isset($_POST['status_pinjam']) ? htmlspecialchars(trim($_POST['status_pinjam'])) : '';
  $keterangan = isset($_POST['keterangan']) ? htmlspecialchars(trim($_POST['keterangan'])) : '';

  if (empty($id_ruangan)) {
    $errorMessages[] = "Ruangan harus dipilih.";
  }

  if (empty($username)) {
    $errorMessages[] = "Username harus dipilih.";
  }

  if (empty($waktu_pengajuan)) {
    $errorMessages[] = "Waktu pengajuan harus diisi.";
  } elseif (!preg_match('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}/', $waktu_pengajuan)) {
    $errorMessages[] = "Format waktu pengajuan tidak valid.";
  }

  if (empty($status_pinjam)) {
    $errorMessages[] = "Status pinjam harus dipilih.";
  }

  if (empty($keterangan)) {
    $errorMessages[] = "Keterangan tidak boleh kosong.";
  }

  if (empty($errorMessages)) {
    if (isset($_POST['action']) && $_POST['action'] == 'create') {
      createPeminjaman($id_peminjaman, $id_ruangan, $username, $waktu_pengajuan, $status_pinjam, $keterangan);
      echo "Peminjaman berhasil ditambahkan!";
    } elseif (isset($_POST['action']) && $_POST['action'] == 'update') {
      updatePeminjaman($id_peminjaman, $id_ruangan, $username, $waktu_pengajuan, $status_pinjam, $keterangan);
      echo "Peminjaman berhasil diperbarui!";
    }
  }
}

if (isset($_GET['id_peminjaman'])) {
  $peminjaman = getPeminjamanById($_GET['id_peminjaman']);
  $action = 'update';
} else {
  $peminjaman = null;
}

$conn = koneksiDB();
$queryRuangan = "SELECT id_ruangan, nama_ruangan FROM tb_ruangan";
$ruanganResult = $conn->query($queryRuangan);
$ruanganList = $ruanganResult->fetch_all(MYSQLI_ASSOC);

$usernames = getUsernames();

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Input Peminjaman</title>
</head>

<body>
  <h2><?php echo $peminjaman ? "Edit Peminjaman" : "Tambah Peminjaman"; ?></h2>

  <?php if (!empty($errorMessages)): ?>
    <div style="color: red;">
      <ul>
        <?php foreach ($errorMessages as $message): ?>
          <li><?php echo $message; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST">
    <input type="hidden" name="action" value="<?php echo $action; ?>">

    <?php if ($action == 'update'): ?>
      <input type="hidden" name="id_peminjaman" value="<?php echo htmlspecialchars($peminjaman['id_peminjaman']); ?>">
    <?php endif; ?>

    <label for="id_ruangan">Ruangan:</label>
    <select name="id_ruangan" id="id_ruangan" required>
      <option value="">Pilih Ruangan</option>
      <?php foreach ($ruanganList as $ruangan): ?>
        <option value="<?php echo $ruangan['id_ruangan']; ?>" <?php echo $peminjaman && $peminjaman['id_ruangan'] == $ruangan['id_ruangan'] ? 'selected' : ''; ?>>
          <?php echo $ruangan['nama_ruangan']; ?>
        </option>
      <?php endforeach; ?>
    </select>
    <br>

    <label for="username">Username:</label>
    <select name="username" id="username" required>
      <option value="">Pilih Username</option>
      <?php foreach ($usernames as $user): ?>
        <option value="<?php echo $user; ?>" <?php echo $peminjaman && $peminjaman['username'] == $user ? 'selected' : ''; ?>>
          <?php echo $user; ?>
        </option>
      <?php endforeach; ?>
    </select>
    <br>

    <label for="waktu_pengajuan">Waktu Pengajuan:</label>
    <input type="datetime-local" name="waktu_pengajuan" id="waktu_pengajuan"
      value="<?php echo $peminjaman ? $peminjaman['waktu_pengajuan'] : ''; ?>" required>
    <br>

    <label for="status_pinjam">Status Pinjam:</label>
    <select name="status_pinjam" id="status_pinjam" required>
      <option value="Diajukan" <?php echo $peminjaman && $peminjaman['status_pinjam'] == 'Diajukan' ? 'selected' : ''; ?>>Diajukan</option>
      <option value="Disetujui" <?php echo $peminjaman && $peminjaman['status_pinjam'] == 'Disetujui' ? 'selected' : ''; ?>>Disetujui</option>
      <option value="Menunggu" <?php echo $peminjaman && $peminjaman['status_pinjam'] == 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
      <option value="Ditolak" <?php echo $peminjaman && $peminjaman['status_pinjam'] == 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
    </select>
    <br>

    <label for="keterangan">Keterangan:</label>
    <textarea name="keterangan" id="keterangan" required><?php echo $peminjaman ? $peminjaman['keterangan'] : ''; ?></textarea>
    <br>

    <button type="submit"><?php echo $peminjaman ? "Update" : "Tambah"; ?> Peminjaman</button>
  </form>

  <br>
  <a href="list_peminjaman.php">List Peminjaman</a>
</body>

</html>