<?php
include 'fungsi.php';

$username = $fullname = $password = $level = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Ambil nilai dari POST
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
  $password = isset($_POST['password']) ? trim($_POST['password']) : '';
  $level = isset($_POST['level']) ? trim($_POST['level']) : '';

  if (empty($username)) {
    $errors[] = "Username tidak boleh kosong.";
  } elseif (strlen($username) < 5) {
    $errors[] = "Username harus terdiri dari minimal 5 karakter.";
  } elseif (!isset($_POST['action']) || $_POST['action'] == 'create') {
    if (isUsernameExists($username)) {
      $errors[] = "Username sudah terdaftar.";
    }
  }

  if (empty($fullname)) {
    $errors[] = "Full name tidak boleh kosong.";
  }

  if (empty($password)) {
    $errors[] = "Password tidak boleh kosong.";
  } elseif (strlen($password) < 8) {
    $errors[] = "Password harus terdiri dari minimal 8 karakter.";
  }

  $allowedLevels = ['Admin', 'User', 'Staff'];
  if (!in_array($level, $allowedLevels)) {
    $errors[] = "Level tidak valid.";
  }

  if (empty($errors)) {
    if ($_POST['action'] == 'create') {
      if (createUser($username, $fullname, $password, $level)) {
        echo "<p>User berhasil ditambahkan!</p>";
      } else {
        $errors[] = "Gagal menambahkan user.";
      }
    } elseif ($_POST['action'] == 'update') {
      if (updateUser($username, $fullname, $password, $level)) {
        echo "<p>User berhasil diperbarui!</p>";
      } else {
        $errors[] = "Gagal memperbarui user.";
      }
    }
  }
}

$user = null;
if (isset($_GET['username'])) {
  $user = getUserByUsername($_GET['username']);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Input User</title>
</head>

<body>
  <h2><?php echo $user ? "Edit User" : "Tambah User"; ?></h2>

  <!-- Menampilkan pesan error -->
  <?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endforeach; ?>
  <?php endif; ?>

  <form method="POST">
    <input type="hidden" name="action" value="<?php echo $user ? 'update' : 'create'; ?>">

    <label for="username">Username:</label>
    <input type="text" name="username" id="username"
      value="<?php echo htmlspecialchars($user ? $user['username'] : $username); ?>"
      required minlength="5" <?php echo $user ? 'readonly' : ''; ?>>
    <br>

    <label for="fullname">Full Name:</label>
    <input type="text" name="fullname" id="fullname"
      value="<?php echo htmlspecialchars($user ? $user['fullname'] : $fullname); ?>" required>
    <br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required minlength="8">
    <br>

    <label for="level">Level:</label>
    <select name="level" id="level" required>
      <option value="Admin" <?php echo $user && $user['level'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
      <option value="User" <?php echo $user && $user['level'] == 'User' ? 'selected' : ''; ?>>User</option>
      <option value="Staff" <?php echo $user && $user['level'] == 'Staff' ? 'selected' : ''; ?>>Staff</option>
    </select>
    <br>

    <button type="submit"><?php echo $user ? "Update" : "Tambah"; ?> User</button>
  </form>

  <br>
  <a href="list_user.php">Kembali ke daftar user</a>
</body>

</html>