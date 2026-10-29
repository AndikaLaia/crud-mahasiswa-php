<?php
require "config/koneksi.php";
require "config/lang.php";

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM mahasiswa ORDER BY id DESC");
$stmt->execute();
$mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $txt['title']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <div>
                <a href="?lang=id">Indonesian</a> | <a href="?lang=en">English</a>
            </div>
            <a href="logout.php" class="btn btn-danger"><?= $txt['logout']; ?></a>
        </div>

        <h2><?= $txt['title']; ?></h2>
        <p><?= $txt['welcome']; ?>, <b><?= htmlspecialchars($_SESSION['user_logged_in']); ?></b></p>
        <br>
        
        <a href="tambah.php" class="btn">+ <?= $txt['add_data']; ?></a>
        <br><br>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th><?= $txt['nim']; ?></th>
                    <th><?= $txt['nama']; ?></th>
                    <th><?= $txt['email']; ?></th>
                    <th><?= $txt['jurusan']; ?></th>
                    <th><?= $txt['angkatan']; ?></th>
                    <th><?= $txt['action']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($mhs['nim']); ?></td>
                    <td><?= htmlspecialchars($mhs['nama']); ?></td>
                    <td><?= htmlspecialchars($mhs['email']); ?></td>
                    <td><?= htmlspecialchars($mhs['jurusan']); ?></td>
                    <td><?= htmlspecialchars($mhs['angkatan']); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $mhs['id']; ?>"><?= $txt['edit']; ?></a> | 
                        <a href="hapus.php?id=<?= $mhs['id']; ?>" style="color:red;" onclick="return confirm('Yakin mau hapus data ini?')"><?= $txt['delete']; ?></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>