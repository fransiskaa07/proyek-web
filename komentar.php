<?php
include "koneksi.php";

if (isset($_POST['foto_id']) && isset($_POST['comment'])) {
    $fotoID = intval($_POST['foto_id']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $userID = $_SESSION['user_id'];  // Assuming the user is logged in and their user ID is in the session

    // Insert the comment into the database
    mysqli_query($con, "INSERT INTO komentarfoto (FotoID, UserID, Comment) VALUES ($fotoID, $userID, '$KomentarID')");

    // Redirect back to the gallery page after commenting
    header("Location: gallery.php");
}
?>
