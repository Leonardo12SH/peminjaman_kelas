<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: ../index.php');
  exit;
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Peminjaman Kelas</title>
</head>

<frameset rows="40, *, 30" frameborder="1">
  <!-- Top navbar -->
  <frame src="navbar.php" name="navbar" noresize scrolling="no">

    <!-- Content area divided into two columns -->
    <frameset cols="200, *" frameborder="1">
      <!-- Sidebar (left side) -->
      <frame src="sidebar.php" name="sidebar">

        <!-- Main content area -->
        <frame src="../list_peminjaman.php" name="maincontent">
    </frameset>

    <!-- Footer -->
    <frame src="footer.php" name="footer" noresize scrolling="no">
</frameset>

</html>