<?php
session_start(); // Start the session

// Check if the username session variable is set
if (!isset($_SESSION['username'])) {
  header('Location: ../index.php'); // Redirect to login page if not logged in
  exit;
}

$username = $_SESSION['username']; // Retrieve the username
?>

<!DOCTYPE html>
<html>

<body>
  <div style="display: flex; justify-content: space-between; padding: 5px;">
    <!-- Display username on the left -->
    <div>
      Selamat Datang, <?php echo htmlspecialchars($username); ?>!
    </div>

    <!-- Logout link on the right -->
    <div>
      <a href="../logout.php" target="_top">Logout</a>
    </div>
  </div>
</body>

</html>