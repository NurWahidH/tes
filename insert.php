<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tanggal = $_POST['tanggal'];
    $isi_berita = $_POST['isi_berita'];
    
    // Pastikan folder untuk menyimpan gambar ada
    $target_dir = "assets/images/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    // Cek apakah file gambar diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];
        $target_file = $target_dir . basename($gambar);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Cek apakah file benar-benar gambar
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            die("File bukan gambar.");
        }
        
        // Cek ukuran file (maksimum 5MB)
        if ($_FILES["gambar"]["size"] > 5000000) {
            die("Maaf, file terlalu besar.");
        }
        
        // Izinkan format tertentu
        $allowed_formats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            die("Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.");
        }
        
        // Coba upload file
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // File berhasil diupload, sekarang masukkan data ke database
            $result = mysqli_query($koneksi, "INSERT INTO berita (judul, gambar, isi_berita, penulis, tanggal) VALUES ('$judul', '$gambar', '$isi_berita', '$penulis', '$tanggal')");

            if (!$result) {
                echo "Error database: " . mysqli_error($koneksi);
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            echo "Maaf, terjadi error saat mengupload file.";
        }
    } else {
        echo "Error: " . $_FILES['gambar']['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Berita</title>
</head>
<body>
    <h2>Input Berita</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Judul Berita:</label><br>
        <input type="text" name="judul" required><br><br>
        
        <label>Gambar:</label><br>
        <input type="file" name="gambar" accept="image/*" required><br><br>
        
        <label>Isi Berita:</label><br>
        <textarea name="isi_berita" rows="5" cols="40" required></textarea><br><br>
        
        <label>Penulis:</label><br>
        <input type="text" name="penulis" required><br><br>
        
        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" required><br><br>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>