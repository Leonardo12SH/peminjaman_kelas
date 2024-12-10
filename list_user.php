<?php
include 'fungsi.php';
$users = getUsers();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar User</title>
</head>

<body>
  <h2>Daftar User</h2>

  <a href="user.php">Tambah User</a>
  <hr><br>

  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>Username</th>
        <th>Full Name</th>
        <th>Level</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($users) > 0): ?>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
            <td><?php echo htmlspecialchars($user['level']); ?></td>
            <td>
              <a href="user.php?username=<?php echo urlencode($user['username']); ?>">Edit</a> |
              <a href="?delete_user&username=<?php echo urlencode($user['username']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4">Tidak ada user ditemukan.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  <br>
</body>

</html>