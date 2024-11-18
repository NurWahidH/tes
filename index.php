<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> 
</head>
<body>
    <h2>Portal Berita</h2>
    <a href="insert.php">Insert Berita</a>
    <br><br>

    <div class="news-container">
        <?php
        include 'koneksi.php';

        // Ambil data dari database
        $result = mysqli_query($koneksi, "SELECT * FROM berita");

        while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="news-item">
                <h3><?php echo $row['judul']; ?></h3>
                <img src="assets/images/<?php echo $row['gambar']; ?>" alt="Gambar Berita" class="news-image">
                <p><?php echo $row['isi_berita']; ?></p>
                <p><strong>Penulis:</strong> <?php echo $row['penulis']; ?></p>
                <p><strong>Tanggal:</strong> <?php echo $row['tanggal']; ?></p>
                <div class="actions">
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>