<?php

namespace App;

use Exception;

class AdminManager
{
    private $filePesanan;

    public function __construct($filePesanan)
    {
        $this->filePesanan = $filePesanan;
    }

    public function getAllOrders()
    {
        if (!file_exists($this->filePesanan)) {
            return [];
        }

        return json_decode(
            file_get_contents($this->filePesanan),
            true
        ) ?? [];
    }

    public function updateStatusPesanan(
        $idPesanan,
        $statusBaru
    ) {

        $orders = $this->getAllOrders();

        $statusValid = [
            'Menunggu Pembayaran',
            'Diproses',
            'Dikirim',
            'Selesai',
            'Dibatalkan'
        ];

        if (!in_array($statusBaru, $statusValid)) {

            throw new Exception(
                "Status tidak valid."
            );
        }

        $ketemu = false;

        foreach ($orders as $index => $order) {

            if ($order['id_pesanan'] === $idPesanan) {

                $orders[$index]['status'] =
                    $statusBaru;

                $ketemu = true;

                break;
            }
        }

        if (!$ketemu) {

            throw new Exception(
                "Pesanan tidak ditemukan."
            );
        }

        file_put_contents(
            $this->filePesanan,
            json_encode($orders, JSON_PRETTY_PRINT)
        );

        return true;
    }
}