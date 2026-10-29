<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'en' ? 'en' : 'id';
}

$lang = $_SESSION['lang'] ?? 'id';

$dict = [
    'id' => [
        'title' => 'Sistem Informasi Mahasiswa',
        'login' => 'Masuk',
        'logout' => 'Keluar',
        'welcome' => 'Selamat Datang',
        'add_data' => 'Tambah Data',
        'nim' => 'NIM',
        'nama' => 'Nama',
        'email' => 'Email',
        'jurusan' => 'Jurusan',
        'angkatan' => 'Angkatan',
        'action' => 'Aksi',
        'edit' => 'Ubah',
        'delete' => 'Hapus',
        'save' => 'Simpan',
        'back' => 'Kembali'
    ],
    'en' => [
        'title' => 'Student Information System',
        'login' => 'Login',
        'logout' => 'Logout',
        'welcome' => 'Welcome',
        'add_data' => 'Add Data',
        'nim' => 'NIM',
        'nama' => 'Name',
        'email' => 'Email',
        'jurusan' => 'Major',
        'angkatan' => 'Cohort',
        'action' => 'Action',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'back' => 'Back'
    ]
];

$txt = $dict[$lang];
?>