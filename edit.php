<?php
include 'db.php';
include 'data.php';

$database = new Database();
$db = $database->conn;
$product = new Data($db);

// Mendapatkan ID Data dari parameter URL
$id = isset($_GET['id']) ? $_GET['id'] : die('Error: Data tidak ditemukan.');

// Mendapatkan data Data berdasarkan ID
$product->id = $id;
$result = $product->read();

// Memastikan data Data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($_POST) {
        // Mendapatkan data dari formulir yang diisi
        $product->nama = $_POST['nama'];
        $product->nim = $_POST['nim'];

        // Proses unggah file/foto
        $target_directory = "uploads/";
        $target_file = $target_directory . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $product->foto = $target_file;
        } else {
            echo "Maaf, file tidak berhasil diunggah.";
        }

        // Memperbarui data Data
        if ($product->update()) {
            echo "Data berhasil diperbarui.";
        } else {
            echo "Gagal memperbarui Data.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit-style.css">
    <title>Edit Data</title>
</head>

<body>

    <div class="grid-container">
        <div class="grid-item">
            <h2>Edit Produk</h2>
    <form action="<?php echo "edit.php?id={$id}"; ?>" method="post" enctype="multipart/form-data">
        Nama: <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required><br>
        Nim: <input type="number" name="nim" value="<?php echo $row['nim']; ?>" required><br>
        Foto: <input type="file" name="foto" accept="image/*"><br>
        <img src="<?php echo $row['foto']; ?>" alt="Foto Produk" style="width: 100px; height: 100px;"><br>
        <input type="submit" value="Simpan Perubahan" id="tombol">
    </form>

        </div>
    </div>
    
</body>

</html>

<?php
} else {
    echo 'Error: Produk tidak ditemukan.';
}
?>
