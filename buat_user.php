<?php
require "config/koneksi.php";

$pesan = "";

if (isset($_POST['register'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $pesan = "<div class='alert-error'>Username dan password wajib diisi!</div>";
    } else {
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:u, :p)");
            $stmt->execute([':u' => $username, ':p' => $hash_password]);
            $pesan = "<p style='color:green; margin-bottom:15px;'>User <b>$username</b> berhasil dibuat! <a href='login.php'>Login di sini</a></p>";
        } catch (PDOException $e) {
            $pesan = "<div class='alert-error'>Gagal: Username sudah terpakai!</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Buat User Baru</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <h2>Tambah User Baru</h2>
        <?= $pesan; ?>

        <form method="POST" action="">
            <label>Username Baru:</label>
            <input type="text" name="username" placeholder="Masukkan username baru">

            <label>Password Baru:</label>
            <input type="password" name="password" placeholder="Masukkan password baru">

            <button type="submit" name="register" style="width: 100%; margin-top: 20px;">Buat User</button>
        </form>

        <p style="margin-top: 15px; text-align: center;">
            <a href="login.php">Kembali ke Halaman Login</a>
        </p>
    </div>
</body>
</html>