<?php
session_start();
include "koneksi.php";

$fotoID = intval($_POST['FotoID']);
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$tanggal = $_POST['tanggal'];
$albumID = $_POST['album'];
$foto = $_FILES['foto'];

$query = mysqli_query($con, "SELECT LokasiFoto FROM foto WHERE FotoID = $fotoID");
$data_lama = mysqli_fetch_assoc($query);

if (!$data_lama) {
    echo "Data tidak ditemukan.";
    exit;
}

if (isset($foto) && $foto['error'] == 0) {
    $target_dir = "berkas/";
    $target_file = $target_dir . basename($foto["name"]);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (file_exists($data_lama['LokasiFoto'])) {
        unlink($data_lama['LokasiFoto']);
    }

    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
        $lokasi_foto = $target_file;
    } else {
        echo "Gagal mengunggah file.";
        exit;
    }
} else {
    $lokasi_foto = $data_lama['LokasiFoto'];
}

$query_update = mysqli_query(
    $con,
    "UPDATE foto SET 
        JudulFoto = '$judul',
        DeskripsiFoto = '$deskripsi',
        TanggalUnggah = '$tanggal',
        LokasiFoto = '$lokasi_foto',
        AlbumID = '$albumID'
     WHERE FotoID = $fotoID"
);

if ($query_update) {
    $_SESSION['message'] = "Data berhasil diperbarui.";
    header("Location: dashboard.php");
    exit();
} else {
    echo "Terjadi kesalahan saat memperbarui data: " . mysqli_error($con);
}
?>
