<?php
include 'fungsi.php';
$aktivitas = getAllAktivitas();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log Aktivitas</title>
</head>

<body>
  <h2>Log Aktivitas</h2>
  <table border="1" cellpadding="5" cellspacing="0">
    <tr>
      <th>ID Aktivitas</th>
      <th>Pengguna</th>
      <th>Jenis Aktivitas</th>
      <th>Keterangan</th>
      <th>Waktu</th>
    </tr>
    <?php foreach ($aktivitas as $a): ?>
      <tr>
        <td><?php echo $a['id_aktivitas']; ?></td>
        <td><?php echo htmlspecialchars($a['pengguna']); ?></td>
        <td><?php echo htmlspecialchars($a['jenis_aktivitas']); ?></td>
        <td><?php echo htmlspecialchars($a['keterangan']); ?></td>
        <td><?php echo $a['waktu']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>