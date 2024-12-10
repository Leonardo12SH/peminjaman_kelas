<?php
include 'fungsi.php';

$peminjamanList = getPeminjaman();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Peminjaman</title>
</head>

<body>
  <h2>Daftar Peminjaman Kelas</h2>

  <a href="peminjaman.php">Tambah Peminjaman</a>
  <hr><br>
  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>Nama Ruangan</th>
        <th>Username</th>
        <th>Waktu Pengajuan</th>
        <th>Status Pinjam</th>
        <th>Keterangan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($peminjamanList as $peminjaman): ?>
        <tr>
          <td><?php echo htmlspecialchars($peminjaman['nama_ruangan']); ?></td>
          <td><?php echo htmlspecialchars($peminjaman['username']); ?></td>
          <td><?php echo htmlspecialchars($peminjaman['waktu_pengajuan']); ?></td>
          <td><?php echo htmlspecialchars($peminjaman['status_pinjam']); ?></td>
          <td><?php echo htmlspecialchars($peminjaman['keterangan']); ?></td>
          <td>
            <?php if ($peminjaman['status_pinjam'] === 'Disetujui'): ?>
              <a href="peminjaman_detail.php?id_peminjaman=<?php echo $peminjaman['id_peminjaman']; ?>">Detail</a> |
            <?php endif; ?>
            <a href="peminjaman.php?id_peminjaman=<?php echo $peminjaman['id_peminjaman']; ?>">Edit</a> |
            <a href="?delete_peminjaman&id=<?php echo $peminjaman['id_peminjaman']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">Hapus</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <br>
</body>

</html>