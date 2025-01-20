<?php
include "koneksi.php";
$judul = $_POST["judul"];
$deskripsi = $_POST['deskripsi'];
$tanggal = $_POST['tanggal'];
$albumID = $_POST['album'];
$UserID = $_POST['UserID'];
$foto = $_FILES['foto'];

if (isset($foto) && $foto['error'] == 0) {
    $target_dir = "berkas/";
    $target_file = basename($foto["name"]);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
        $query = mysqli_query(
            $con,
            "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFoto, AlbumID, UserID) 
             VALUES ('$judul','$deskripsi', '$tanggal', '$target_file', '$albumID','$UserID')"
        );

        if ($query) {
            header("Location: dashboard.php"); 
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Gagal mengunggah file.";
    }
} else {
    echo "Tidak ada file yang diunggah atau terjadi kesalahan.";
}
?>
