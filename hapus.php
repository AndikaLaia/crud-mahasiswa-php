<?php
require "config/koneksi.php";
session_start();

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
}

header("Location: index.php");
exit;
?>