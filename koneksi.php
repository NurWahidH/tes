<?php
$koneksi = mysqli_connect("localhost", "root", "", "berita1");


if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>