<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'peminjaman';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$filterStartDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$filterEndDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$query = "SELECT p.id_peminjaman, p.id_ruangan, r.nama_ruangan, u.fullname, p.waktu_pengajuan, p.status_pinjam, p.keterangan 
          FROM tb_peminjaman p
          INNER JOIN tb_ruangan r ON p.id_ruangan = r.id_ruangan
          INNER JOIN tb_user u ON p.username = u.username";

if (!empty($filterStartDate) && !empty($filterEndDate)) {
  $query .= " WHERE DATE(p.waktu_pengajuan) BETWEEN '$filterStartDate' AND '$filterEndDate'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Peminjaman</title>
</head>

<body>

  <h2>Laporan Peminjaman Kelas</h2>

  <!-- Form Filter -->
  <form method="POST" class="row g-3 mb-4">

    <label for="start_date">Tanggal Mulai</label>
    <input type="date" name="start_date" id="start_date" value="<?php echo $filterStartDate; ?>">

    <label for="end_date">Tanggal Akhir</label>
    <input type="date" name="end_date" id="end_date" value="<?php echo $filterEndDate; ?>">

    <button type="submit">Filter</button>
    <button type="button" onclick="window.print()">Print</button>

  </form>

  <hr><br>

  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>ID Peminjaman</th>
        <th>Nama Ruangan</th>
        <th>Nama User</th>
        <th>Waktu Pengajuan</th>
        <th>Status</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id_peminjaman']; ?></td>
            <td><?php echo $row['nama_ruangan']; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['waktu_pengajuan']; ?></td>
            <td><?php echo $row['status_pinjam']; ?></td>
            <td><?php echo $row['keterangan']; ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="6">Tidak ada data.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>

</html>
<?php $conn->close(); ?>