<?php
include 'koneksi.php';

// Ambil ID dari parameter GET
$id = $_GET['id'];

// Ambil data berita berdasarkan ID
$result = mysqli_query($koneksi, "SELECT * FROM berita WHERE id=$id");
$row = mysqli_fetch_assoc($result);

// Cek jika data tidak ditemukan
if (!$row) {
    die("Data tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tanggal = $_POST['tanggal'];
    $isi_berita = $_POST['isi_berita'];

    // Periksa apakah gambar baru di-upload
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($gambar);
        
        // Coba upload gambar
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Jika upload berhasil, gunakan gambar baru
            $gambar_to_update = $gambar;
        } else {
            echo "Gagal mengupload gambar.";
            exit();
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar yang lama
        $gambar_to_update = $row['gambar'];
    }

    // Update data berita di database
    $query = "UPDATE berita SET judul='$judul', gambar='$gambar_to_update', isi_berita='$isi_berita', penulis='$penulis', tanggal='$tanggal' WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
</head>
<body>
    <h2>Edit Berita</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Judul Berita:</label><br>
        <input type="text" name="judul" value="<?php echo htmlspecialchars($row['judul']); ?>" required><br><br>
        
        <label>Gambar:</label><br>
        <input type="file" name="gambar"><br><br>
        
        <label>Isi Berita:</label><br>
        <textarea name="isi_berita" rows="5" cols="40" required><?php echo htmlspecialchars($row['isi_berita']); ?></textarea><br><br>
        
        <label>Penulis:</label><br>
        <input type="text" name="penulis" value="<?php echo htmlspecialchars($row['penulis']); ?>" required><br><br>
        
        <label>Tanggal:</label><br>
        <input type="date" name="tanggal" value="<?php echo htmlspecialchars($row['tanggal']); ?>" required><br><br>
        
        <button type="submit">Update</button>
    </form>
</body>
</html>