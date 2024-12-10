<?php
include 'fungsi.php';

// Ambil id_peminjaman dari parameter URL
$id_peminjaman = isset($_GET['id_peminjaman']) ? $_GET['id_peminjaman'] : null;

if (!$id_peminjaman) {
  echo "ID Peminjaman tidak ditemukan.";
  exit;
}

// Ambil data detail peminjaman berdasarkan id_peminjaman
$detailPeminjaman = getDetailPeminjaman($id_peminjaman);

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Peminjaman</title>
</head>

<body>
  <h2>Detail Peminjaman Kelas</h2>

  <?php if (!$detailPeminjaman): ?>
    <!-- Tampilkan link jika data belum ada -->
    <a href="peminjaman_info.php?id_peminjaman=<?php echo $id_peminjaman; ?>">Tambah Detail Peminjaman</a>
    <hr><br>
  <?php endif; ?>

  <?php if ($detailPeminjaman):
    $i = 1;
  ?>
    <?php foreach ($detailPeminjaman as $detail): ?>
      <table border="1" cellpadding="5" cellspacing="0">
        <tbody>
          <tr>
            <td>Tanggal Pinjam</td>
            <td><?php echo htmlspecialchars($detail['tanggal_pinjam']); ?></td>
          </tr>
          <tr>
            <td>Tanggal Pengembalian</td>
            <td><?php echo $detail['tanggal_pengembalian'] ? htmlspecialchars($detail['tanggal_pengembalian']) : '-'; ?></td>
          </tr>
          <tr>
            <td>Kondisi Kelas Awal</td>
            <td><?php echo htmlspecialchars($detail['kondisi_kelas_awal']); ?></td>
          </tr>
          <tr>
            <td>Status</td>
            <td><?php echo htmlspecialchars($detail['status']); ?></td>
          </tr>
          <tr>
            <td>Kondisi Kelas Pengembalian</td>
            <td><?php echo $detail['kondisi_kelas_pengembalian'] ? htmlspecialchars($detail['kondisi_kelas_pengembalian']) : '-'; ?></td>
          </tr>
          <tr>
            <td>Keterangan</td>
            <td><?php echo $detail['keterangan'] ? htmlspecialchars($detail['keterangan']) : '-'; ?></td>
          </tr>
          <tr>
            <td>Action</td>
            <td>
              <a href="peminjaman_info.php?id_detail=<?php echo $detail['id_detail_peminjaman']; ?>&&id_peminjaman=<?php echo $id_peminjaman ?>">Edit</a>
            </td>
          </tr>
        </tbody>
      </table>
    <?php endforeach; ?>

  <?php else: ?>
    <p>Tidak ada detail peminjaman untuk ID ini.</p>
  <?php endif; ?>
  <br>
  <a href="list_peminjaman.php">Kembali</a>
</body>

</html>