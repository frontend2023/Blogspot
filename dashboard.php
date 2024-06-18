<?php
require_once 'connection.php';

// Cek jika pengguna belum login, redirect ke login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>

<body>
    <h1>Welcome to the Dashboard</h1>
    <p>Anda berhasil login!

    </p><?php include 'navbar.php'; ?>
</body>

</html>