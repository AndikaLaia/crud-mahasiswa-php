<?php
require "config/koneksi.php";
require "config/lang.php";

$error = "";

if (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username dan password wajib diisi!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $txt['login']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <div class="top-bar">
            <h2><?= $txt['login']; ?></h2>
            <div>
                <a href="?lang=id">ID</a> | <a href="?lang=en">EN</a>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert-error"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Masukkan username">

            <label>Password:</label>
            <input type="password" name="password" placeholder="Masukkan password">

            <button type="submit" name="login" style="width: 100%; margin-top: 20px;"><?= $txt['login']; ?></button>
        </form>
        
        <p style="margin-top: 15px; text-align: center;">
            Belum punya akun? <a href="buat_user.php">Buat User Baru</a>
        </p>
    </div>
</body>
</html>