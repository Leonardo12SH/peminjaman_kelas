<?php
include 'fungsi.php';

$id_ruangan = $nama_ruangan = $status = "";
$errors = [];
$action = 'create';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id_ruangan = trim($_POST['id_ruangan']);
  $nama_ruangan = trim($_POST['nama_ruangan']);
  $status = isset($_POST['status']) ? $_POST['status'] : '';

  if (empty($id_ruangan)) {
    $errors[] = "ID Ruangan tidak boleh kosong.";
  } elseif (strlen($id_ruangan) < 3) {
    $errors[] = "ID Ruangan harus terdiri dari minimal 3 karakter.";
  } elseif ($action === 'create' && getRuanganById($id_ruangan)) {
    $errors[] = "ID Ruangan sudah terdaftar.";
  }

  if (empty($nama_ruangan)) {
    $errors[] = "Nama Ruangan tidak boleh kosong.";
  } elseif ($action === 'create' && isNamaRuanganExists($nama_ruangan)) {
    $errors[] = "Nama Ruangan sudah terdaftar.";
  }

  $allowedStatus = ['Tersedia', 'Dipinjam'];
  if (!in_array($status, $allowedStatus)) {
    $errors[] = "Status tidak valid.";
  }

  if (empty($errors)) {
    if ($_POST['action'] === 'create') {
      if (createRuangan($id_ruangan, $nama_ruangan, $status)) {
        echo "Ruangan berhasil ditambahkan!";
      } else {
        echo "Terjadi kesalahan saat menambahkan ruangan.";
      }
    } elseif ($_POST['action'] === 'update') {
      if (updateRuangan($id_ruangan, $nama_ruangan, $status)) {
        echo "Ruangan berhasil diperbarui!";
      } else {
        echo "Terjadi kesalahan saat memperbarui ruangan.";
      }
    }
  } else {
    foreach ($errors as $error) {
      echo "<p style='color: red;'>$error</p>";
    }
  }
}

if (isset($_GET['id_ruangan'])) {
  $ruangan = getRuanganById($_GET['id_ruangan']);
  $action = 'update';
} else {
  $ruangan = null;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Input Ruangan</title>
</head>

<body>
  <h2><?php echo $ruangan ? "Edit Ruangan" : "Tambah Ruangan"; ?></h2>

  <form method="POST">
    <input type="hidden" name="action" value="<?php echo $action; ?>">

    <?php if ($action === 'update'): ?>
      <input type="hidden" name="id_ruangan" value="<?php echo $ruangan['id_ruangan']; ?>">
    <?php endif; ?>

    <label for="id_ruangan">ID Ruangan:</label>
    <input type="text" name="id_ruangan" id="id_ruangan" value="<?php echo $ruangan ? htmlspecialchars($ruangan['id_ruangan']) : htmlspecialchars($id_ruangan); ?>" <?php echo $action === 'update' ? 'readonly' : ''; ?> required minlength="4" maxlength="4" placeholder="R001">
    <br>

    <label for="nama_ruangan">Nama Ruangan:</label>
    <input type="text" name="nama_ruangan" id="nama_ruangan" value="<?php echo $ruangan ? htmlspecialchars($ruangan['nama_ruangan']) : htmlspecialchars($nama_ruangan); ?>" required>
    <br>

    <label for="status">Status:</label>
    <select name="status" id="status" required>
      <option value="Tersedia" <?php echo $ruangan && $ruangan['status'] === 'Tersedia' ? 'selected' : ''; ?>>Tersedia</option>
      <option value="Dipinjam" <?php echo $ruangan && $ruangan['status'] === 'Dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
    </select>
    <br>

    <button type="submit"><?php echo $ruangan ? "Update Ruangan" : "Tambah Ruangan"; ?></button>
  </form>
  <br>
  <a href="list_ruangan.php">List Ruangan</a>
</body>

</html>