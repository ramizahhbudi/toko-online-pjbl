<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION['user'])) {

    die("Belum login");
}

if ($_SESSION['user']['role'] != 'admin') {

    die("Akses ditolak");
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

<div class="card shadow">

<div class="card-body">

<h1 class="text-success">

ADMIN PANEL BERHASIL

</h1>

<p>
Halo,
<?= $_SESSION['user']['nama'] ?>
</p>

<a href="logout.php" class="btn btn-danger">

Logout

</a>

</div>

</div>

</div>

</body>
</html>