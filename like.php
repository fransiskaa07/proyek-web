<?php
include 'koneksi.php';
session_start();

$foto_id = $_GET['id'] ?? null;
$user_id = $_GET['user_id'] ?? null;

if ($foto_id && $user_id) {
    // Periksa apakah sudah ada like untuk foto dan user ini
    $query_check = "SELECT * FROM `likefoto` WHERE FotoID = ? AND UserID = ?";
    $stmt_check = mysqli_prepare($con, $query_check);
    mysqli_stmt_bind_param($stmt_check, "ii", $foto_id, $user_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Jika sudah ada like, hapus
        $query_delete = "DELETE FROM `likefoto` WHERE FotoID = ? AND UserID = ?";
        $stmt_delete = mysqli_prepare($con, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "ii", $foto_id, $user_id);
        mysqli_stmt_execute($stmt_delete);
        echo "Like dihapus.";  // Mengirimkan respon ke AJAX
    } else {
        // Jika belum ada like, tambahkan
        $query_insert = "INSERT INTO `likefoto` (FotoID, UserID, TanggalLike) VALUES (?, ?, NOW())";
        $stmt_insert = mysqli_prepare($con, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "ii", $foto_id, $user_id);
        mysqli_stmt_execute($stmt_insert);
        echo "Like ditambahkan.";  // Mengirimkan respon ke AJAX
    }
} else {
    echo "ID foto atau user tidak valid!";
    exit;
}
?>
