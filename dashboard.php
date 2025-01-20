<?php
session_start();

// Validasi session
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}

include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(22, 22, 22);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        header h1 {
            font-size: 24px;
        }
        header .logout-btn {
            text-decoration: none;
            background-color: #ff4d4d;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        header .logout-btn:hover {
            background-color: #cc0000;
        }
        .upload-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .upload-section h2 {
            margin-bottom: 20px;
            font-size: 20px;
        }
        .upload-section .form-group {
            margin-bottom: 15px;
        }
        .upload-section .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .upload-section .form-group input,
        .upload-section .form-group textarea,
        .upload-section .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .upload-section .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .upload-section .btn-primary:hover {
            background-color: #0056b3;
        }
        .photo-grid-section {
            margin-top: 40px;
        }
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 5px;  /* Adjusted gap to reduce space between photos */
        }
        .photo-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 80%;
            margin: 0 auto;
            padding: 10px;
        }
        .photo-card:hover {
            transform: translateY(-5px);
        }
        .photo-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .photo-card .photo-info {
            padding: 8px;
        }
        .photo-card .photo-info h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .photo-card .photo-info p {
            margin: 8px 0;
            font-size: 14px;
            color: #666;
        }
        .photo-card .photo-actions {
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            background-color: #f9f9f9;
        }
        .photo-card .photo-actions a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        .photo-card .photo-actions a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
        <h1 style="color: white;">Selamat Datang, <?php echo $_SESSION['Username']; ?>!</h1>
        <div>
            <a href="gallery.php" class="logout-btn" style="background-color:rgb(94, 87, 167);">Back to Gallery</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </header>


        <!-- Form Upload Foto Baru -->
        <section class="upload-section">
            <h2>Unggah Foto Baru</h2>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul">Judul Foto:</label>
                    <input type="text" id="judul" name="judul" placeholder="Masukkan judul foto" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Foto:</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi foto" required></textarea>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal Unggah:</label>
                    <input type="date" id="tanggal" name="tanggal" required>
                </div>
                <div class="form-group">
                    <label for="foto">Upload Foto:</label>
                    <input type="file" id="foto" name="foto" required>
                </div>
                <div class="form-group">
                    <label for="album">Album:</label>
                    <select name="album" id="album" required>
                        <option value="" disabled selected>Pilih Album</option>
                        <?php
                        $query = mysqli_query($con, "SELECT * FROM album");
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<option value='" . $row['AlbumID'] . "'>" . $row['NamaAlbum'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="UserID" value="<?php echo $_SESSION['id']; ?>">
                <button type="submit" class="btn-primary">Submit</button>
            </form>
        </section>

    </div>

</body>
</html>