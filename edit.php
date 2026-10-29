<?php
require "config/koneksi.php";
require "config/lang.php";

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = :id");
$stmt->execute([':id' => $id]);
$mhs = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mhs) { header("Location: index.php"); exit; }

$errors = [];

if (isset($_POST['update'])) {
    $nama     = htmlspecialchars(trim($_POST['nama']));
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $jurusan  = htmlspecialchars(trim($_POST['jurusan']));
    $angkatan = htmlspecialchars(trim($_POST['angkatan']));

    if (empty($nama)) { $errors[] = "Nama tidak boleh kosong."; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "Format email tidak valid."; }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE mahasiswa SET nama = :nama, email = :email, jurusan = :jurusan, angkatan = :angkatan WHERE id = :id");
        $stmt->execute([
            ':nama'     => $nama,
            ':email'    => $email,
            ':jurusan'  => $jurusan,
            ':angkatan' => $angkatan,
            ':id'       => $id
        ]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $txt['edit']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <h2><?= $txt['edit']; ?> Mahasiswa</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert-error">
                <ul style="margin-left: 20px;">
                    <?php foreach ($errors as $err): ?>
                        <li><?= $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label><?= $txt['nim']; ?> (Tidak bisa diubah):</label>
            <input type="text" value="<?= htmlspecialchars($mhs['nim']); ?>" disabled>

            <label><?= $txt['nama']; ?>:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($mhs['nama']); ?>">

            <label><?= $txt['email']; ?>:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($mhs['email']); ?>">

            <label><?= $txt['jurusan']; ?>:</label>
            <input type="text" name="jurusan" value="<?= htmlspecialchars($mhs['jurusan']); ?>">

            <label><?= $txt['angkatan']; ?>:</label>
            <input type="text" name="angkatan" value="<?= htmlspecialchars($mhs['angkatan']); ?>">

            <br><br>
            <button type="submit" name="update"><?= $txt['save']; ?></button>
            <a href="index.php" style="margin-left: 10px;"><?= $txt['back']; ?></a>
        </form>
    </div>
</body>
</html>