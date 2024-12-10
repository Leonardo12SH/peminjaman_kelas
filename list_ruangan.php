<?php
include 'fungsi.php';
$ruanganList = getRuangan();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Ruangan</title>
</head>

<body>
  <h2>Daftar Ruangan Kelas</h2>

  <a href="ruangan.php">Tambah Ruangan</a>
  <hr><br>

  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>ID Ruangan</th>
        <th>Nama Ruangan</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($ruanganList as $ruang) {
        echo "<tr>
                <td>{$ruang['id_ruangan']}</td>
                <td>{$ruang['nama_ruangan']}</td>
                <td>{$ruang['status']}</td>
                <td>
                  <a href='ruangan.php?id_ruangan={$ruang['id_ruangan']}'>Edit</a> | 
                  <a href='?delete_ruangan&id_ruangan={$ruang['id_ruangan']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus user ini?\")'>Hapus</a>
                </td>
              </tr>";
      }
      ?>
    </tbody>
  </table>
</body>

</html>