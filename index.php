<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index-style.css">
    <title>CRUD PHP OOP</title>
</head>

<body>
    <?php
    include 'db.php';
    include 'data.php';

    $database = new Database();
    $db = $database->conn;
    $product = new Data($db);

    if ($_POST) {
        $product->nama = $_POST['nama'];
        $product->nim= $_POST['nim'];

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

        if ($product->create()) {
            echo "data berhasil ditambahkan.";
        } else {
            echo "Gagal menambahkan data.";
        }
    }
    ?>
    <h1>CRUD PHP</h1>
    <div class="grid-container">
        <div class="grid-item form">
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        Nama: <input type="text" name="nama" placeholder="Masukkan Nama" required><br>
        Nim: <input type="number" name="nim" placeholder="Masukkan nim" required><br>
        Foto: <input type="file" name="foto" id="img" accept="image/*" required><br>
        <input type="submit" value="Tambah data" id="tombol">
    </form>
        </div>

        <div class="grid-item hasil">
<h2>Daftar data</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Nim</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        <?php
        $result = $product->read();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['nim']}</td>
                        <td><img src='{$row['foto']}' alt='Foto data' style='width: 100px; height: 100px;'></td>
                        <td>
                            <a href='edit.php?id={$row['id']}'>Edit</a>
                            <a href='delete.php?id={$row['id']}'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data.</td></tr>";
        }
        ?>
    </table>
        </div>


    </div>
    

   

    
</body>

</html>
