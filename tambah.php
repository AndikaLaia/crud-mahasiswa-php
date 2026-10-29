<?php
require "config/koneksi.php";
require "config/lang.php";

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit;
}

$errors = [];

if (isset($_POST['submit'])) {
    $nim      = htmlspecialchars(trim($_POST['nim']));
    $nama     = htmlspecialchars(trim($_POST['nama']));
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $jurusan  = htmlspecialchars(trim($_POST['jurusan']));
    $angkatan = htmlspecialchars(trim($_POST['angkatan']));

    if (empty($nim)) { $errors[] = "NIM tidak boleh kosong."; }
    if (empty($nama)) { $errors[] = "Nama tidak boleh kosong."; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = "Format email tidak valid."; }
    if (empty($jurusan)) { $errors[] = "Jurusan wajib diisi."; }
    if (!is_numeric($angkatan) || strlen($angkatan) != 4) { $errors[] = "Angkatan harus 4 digit tahun."; }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO mahasiswa (nim, nama, email, jurusan, angkatan) VALUES (:nim, :nama, :email, :jurusan, :angkatan)");
            $stmt->execute([
                ':nim'      => $nim,
                ':nama'     => $nama,
                ':email'    => $email,
                ':jurusan'  => $jurusan,
                ':angkatan' => $angkatan
            ]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Gagal menyimpan: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $txt['add_data']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 500px;">
        <h2><?= $txt['add_data']; ?></h2>

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
            <label><?= $txt['nim']; ?>:</label>
            <input type="text" name="nim">

            <label><?= $txt['nama']; ?>:</label>
            <input type="text" name="nama">

            <label><?= $txt['email']; ?>:</label>
            <input type="email" name="email">

            <label><?= $txt['jurusan']; ?>:</label>
            <input type="text" name="jurusan">

            <label><?= $txt['angkatan']; ?>:</label>
            <input type="text" name="angkatan">

            <br><br>
            <button type="submit" name="submit"><?= $txt['save']; ?></button>
            <a href="index.php" style="margin-left: 10px;"><?= $txt['back']; ?></a>
        </form>
    </div>
</body>
</html>