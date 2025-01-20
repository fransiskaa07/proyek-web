<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumière Pict | Photo Studio </title>
    <link rel="stylesheet" href="css/edit.css"/>
</head>
<body>
    
</body>
</html>
<?php
session_start();
include "koneksi.php";

if (isset($_GET['id'])) {
    $fotoID = intval($_GET['id']);

    $query = mysqli_query($con, "SELECT * FROM foto WHERE FotoID = $fotoID");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
</head>
<body>
    <h3>Edit Foto</h3>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="FotoID" value="<?php echo $data['FotoID']; ?>">
        
        <label for="judul">Judul Foto:</label><br>
        <input type="text" id="judul" name="judul" value="<?php echo $data['JudulFoto']; ?>" required><br><br>

        <label for="deskripsi">Deskripsi:</label><br>
        <textarea id="deskripsi" name="deskripsi" rows="4" required><?php echo $data['DeskripsiFoto']; ?></textarea><br><br>

        <label for="tanggal">Tanggal Unggah:</label><br>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo $data['TanggalUnggah']; ?>" required><br><br>

        <label for="album">Pilih Album:</label><br>
        <select name="album" id="album" required>
            <?php
            $query_album = mysqli_query($con, "SELECT * FROM album");
            while ($row = mysqli_fetch_assoc($query_album)) {
                $selected = $row['AlbumID'] == $data['AlbumID'] ? "selected" : "";
                echo "<option value='{$row['AlbumID']}' $selected>{$row['NamaAlbum']}</option>";
            }
            ?>
        </select><br><br>

        <label for="foto">Upload Foto Baru (opsional):</label><br>
        <input type="file" id="foto" name="foto"><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
