<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/src/Checkout.php';

use App\Checkout;

$fileProduk = __DIR__ . '/data/products.json';

$filePesanan = __DIR__ . '/data/orders.json';

$statusSukses = false;

$pesan = "";

$nota = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? '';

    $alamat = $_POST['alamat'] ?? '';

    $inputQty = $_POST['qty'] ?? [];

    $keranjang = array_filter(
        $inputQty,
        function($qty) {
            return (int)$qty > 0;
        }
    );

    try {

        $checkoutManager = new Checkout(
            $fileProduk,
            $filePesanan
        );

        $nota = $checkoutManager->prosesCheckout(
            $email,
            $alamat,
            $keranjang
        );

        $statusSukses = true;

    } catch (Exception $e) {

        $statusSukses = false;

        $pesan = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Hasil Checkout</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light py-5">

<div class="container">

<div class="row justify-content-center">

<div class="col-md-6">

<?php if($statusSukses): ?>

<div class="card shadow border-success">

<div class="card-header bg-success text-white">

Checkout Berhasil

</div>

<div class="card-body">

<p>
ID Pesanan:
<b><?= $nota['id_pesanan'] ?></b>
</p>

<p>
Email:
<?= htmlspecialchars($nota['email']) ?>
</p>

<p>
Alamat:
<?= htmlspecialchars($nota['alamat']) ?>
</p>

<p>
Status:
<?= $nota['status'] ?>
</p>

<h3 class="text-success">

Rp
<?= number_format($nota['total_bayar']) ?>

</h3>

<a href="index.php" class="btn btn-primary">

Kembali

</a>

</div>

</div>

<?php else: ?>

<div class="card shadow border-danger">

<div class="card-header bg-danger text-white">

Checkout Gagal

</div>

<div class="card-body">

<p class="text-danger">

<?= htmlspecialchars($pesan) ?>

</p>

<a href="index.php" class="btn btn-secondary">

Kembali

</a>

</div>

</div>

<?php endif; ?>

</div>

</div>

</div>

</body>
</html>