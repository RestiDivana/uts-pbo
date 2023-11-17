<?php
include 'db.php';
include 'data.php';

$database = new Database();
$db = $database->conn;
$product = new Data($db);

// Mendapatkan ID produk dari parameter URL
$id = isset($_GET['id']) ? $_GET['id'] : die('Error: data tidak ditemukan.');

// Mengatur ID data yang akan dihapus
$product->id = $id;

// Menghapus data
if ($product->delete()) {
    echo "data berhasil dihapus.";
} else {
    echo "Gagal menghapus data.";
}
?>
