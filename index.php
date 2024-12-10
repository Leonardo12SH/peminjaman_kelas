<?php
session_start();
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level = $_POST['level'];

  // Validasi login
  $loginResult = validasiLogin($username, $password);

  if ($loginResult['status']) {

    $_SESSION['username'] = $loginResult['data']['username'];
    $_SESSION['level'] = $loginResult['data']['level'];

    if ($_SESSION['level'] == 'Admin') {
      header('Location: frame/sistem.php');
    } else {
      header('Location: index.php');
    }
    exit();
  } else {
    $errorMessage = $loginResult['message'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <h2>Login</h2>
  <?php if (isset($errorMessage)): ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
  <?php endif; ?>
  <form method="POST" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="hidden" name="level" value="Admin" required>
    <!-- <label for="level">Level:</label>
    <select id="level" name="level" required>
      <option value="Admin">Admin</option>
      <option value="User">User</option>
      <option value="Staff">Staff</option>
    </select> -->
    <br>
    <button type="submit">Login</button>
  </form>
</body>

</html>