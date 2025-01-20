<?php
session_start();
include "koneksi.php";

if (isset($_GET['id'])) {
    $fotoID = intval($_GET['id']); 

    $query = mysqli_query($con, "SELECT LokasiFoto FROM foto WHERE FotoID = $fotoID");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $file_path = $data['LokasiFoto'];
        if (file_exists($file_path)) {
            unlink($file_path); 
        }

        $delete_query = mysqli_query($con, "DELETE FROM foto WHERE FotoID = $fotoID");

        if ($delete_query) {
            $_SESSION['message'] = "Foto berhasil dihapus.";
        } else {
            $_SESSION['message'] = "Terjadi kesalahan saat menghapus data: " . mysqli_error($con);
        }
    } else {
        $_SESSION['message'] = "Data foto tidak ditemukan.";
    }
} else {
    $_SESSION['message'] = "ID foto tidak ditemukan.";
}
header("Location: gallery.php");
exit();
