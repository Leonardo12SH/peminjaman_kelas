<?php
include 'fungsi.php';

$id_peminjaman = isset($_GET['id_peminjaman']) ? intval($_GET['id_peminjaman']) : 0;
$id_detail = isset($_GET['id_detail']) ? intval($_GET['id_detail']) : null;

$detail = [
  'nama_kelas' => '',
  'tanggal_pinjam' => '',
  'tanggal_pengembalian' => '',
  'kondisi_kelas_awal' => '',
  'status' => '',
  'kondisi_kelas_pengembalian' => '',
  'keterangan' => '',
];

// Jika id_detail disediakan, ambil data detail untuk diedit
if ($id_detail) {
  $detail = getDetailById($id_detail);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = [
    'id_peminjaman' => $id_peminjaman,
    'tanggal_pinjam' => $_POST['tanggal_pinjam'],
    'tanggal_pengembalian' => $_POST['tanggal_pengembalian'],
    'kondisi_kelas_awal' => $_POST['kondisi_kelas_awal'],
    'status' => $_POST['status'],
    'kondisi_kelas_pengembalian' => $_POST['kondisi_kelas_pengembalian'],
    'keterangan' => $_POST['keterangan'],
  ];

  if ($id_detail) {
    updateDetailPeminjaman($id_detail, $data);
  } else {
    insertDetailPeminjaman($data);
  }

  header("Location: peminjaman_detail.php?id_peminjaman=$id_peminjaman");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah/Edit Detail Peminjaman</title>
</head>

<body>
  <h2><?php echo $id_detail ? 'Edit' : 'Tambah'; ?> Detail Peminjaman</h2>
  <a href="peminjaman_detail.php?id_peminjaman=<?php echo $id_peminjaman; ?>">Kembali</a>
  <hr><br>

  <form method="post">
    <label>Tanggal Pinjam:</label>
    <input type="date" name="tanggal_pinjam" value="<?php echo htmlspecialchars($detail['tanggal_pinjam']); ?>" required><br><br>

    <label>Tanggal Pengembalian:</label>
    <input type="date" name="tanggal_pengembalian" value="<?php echo htmlspecialchars($detail['tanggal_pengembalian']); ?>"><br><br>

    <label>Kondisi Kelas Awal:</label>
    <select name="kondisi_kelas_awal" required>
      <option value="baik" <?php echo $detail['kondisi_kelas_awal'] === 'baik' ? 'selected' : ''; ?>>Baik</option>
      <option value="kurang" <?php echo $detail['kondisi_kelas_awal'] === 'kurang' ? 'selected' : ''; ?>>Kurang</option>
      <option value="buruk" <?php echo $detail['kondisi_kelas_awal'] === 'buruk' ? 'selected' : ''; ?>>Buruk</option>
    </select><br><br>

    <label>Status:</label>
    <select name="status" required>
      <option value="belum dikembalikan" <?php echo $detail['status'] === 'belum dikembalikan' ? 'selected' : ''; ?>>Belum Dikembalikan</option>
      <option value="telah dikembalikan" <?php echo $detail['status'] === 'telah dikembalikan' ? 'selected' : ''; ?>>Telah Dikembalikan</option>
    </select><br><br>

    <label>Kondisi Kelas Pengembalian:</label>
    <select name="kondisi_kelas_pengembalian">
      <option value="" <?php echo !$detail['kondisi_kelas_pengembalian'] ? 'selected' : ''; ?>>-</option>
      <option value="baik" <?php echo $detail['kondisi_kelas_pengembalian'] === 'baik' ? 'selected' : ''; ?>>Baik</option>
      <option value="kurang" <?php echo $detail['kondisi_kelas_pengembalian'] === 'kurang' ? 'selected' : ''; ?>>Kurang</option>
      <option value="buruk" <?php echo $detail['kondisi_kelas_pengembalian'] === 'buruk' ? 'selected' : ''; ?>>Buruk</option>
    </select><br><br>

    <label>Keterangan:</label>
    <textarea name="keterangan"><?php echo htmlspecialchars($detail['keterangan']); ?></textarea><br><br>

    <button type="submit"><?php echo $id_detail ? 'Update' : 'Tambah'; ?></button>
  </form>
</body>

</html>