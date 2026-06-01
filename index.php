<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'src/Catalog.php';

use App\Catalog;

$katalog = new Catalog(__DIR__ . '/data/products.json');

$keyword = $_GET['cari'] ?? '';

$produkList = $katalog->searchProduct($keyword);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Toko Online</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">

<div class="container">

<a class="navbar-brand">
Toko Online
</a>

<div>

<?php if(isset($_SESSION['user'])): ?>

<span class="text-white me-3">

Halo,
<?= $_SESSION['user']['nama'] ?>

</span>

<a href="logout.php" class="btn btn-danger btn-sm">

Logout

</a>

<?php else: ?>

<a href="login.php" class="btn btn-primary btn-sm">

Login

</a>

<?php endif; ?>

</div>

</div>

</nav>

<div class="container">

<form method="GET" class="d-flex mb-4">

<input
type="text"
name="cari"
class="form-control me-2"
placeholder="Cari produk...">

<button class="btn btn-primary">

Cari

</button>

</form>

<form action="proses.php" method="POST">

<div class="row">

<div class="col-md-8">

<table class="table table-bordered bg-white">

<tr>

<th>Kode</th>
<th>Nama</th>
<th>Harga</th>
<th>Stok</th>
<th>Qty</th>

</tr>

<?php foreach($produkList as $kode => $item): ?>

<tr>

<td><?= $kode ?></td>

<td><?= $item['nama'] ?></td>

<td>
Rp <?= number_format($item['harga']) ?>
</td>

<td><?= $item['stok'] ?></td>

<td>

<input
type="number"
name="qty[<?= $kode ?>]"
value="0"
min="0"
class="form-control">

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

<div class="col-md-4">

<div class="card shadow">

<div class="card-body">

<h4>Checkout</h4>

<input
type="email"
name="email"
class="form-control mb-2"
placeholder="Email"
required>

<textarea
name="alamat"
class="form-control mb-3"
placeholder="Alamat Pengiriman"
required></textarea>

<button class="btn btn-success w-100">

Bayar Sekarang

</button>

</div>

</div>

</div>

</div>

</form>

</div>

</body>
</html>