<?php
include "koneksi.php"; 
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Lumière Pict | Photo Studio </title>
    <meta charset="UTF-8">
    <meta name="description" content="Cassi Photo Studio HTML Template">
    <meta name="keywords" content="photo, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/elegant-icons.css"/>
    <link rel="stylesheet" href="css/fresco.css"/>
    <!-- Main Stylesheets -->
    <link rel="stylesheet" href="css/style.css"/>
    <style>
		/* CSS Grid Styling for Photo Gallery */
		.photo-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Membuat kolom responsif */
			gap: 20px;
			padding: 20px;
		}

		/* Styling untuk setiap kartu foto */
		.photo-card {
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			transition: transform 0.3s ease;
		}

		/* Efek hover pada foto */
		.photo-card:hover {
			transform: translateY(-5px);
		}

		/* Gambar yang ditampilkan dalam kartu */
		.photo-card img {
			width: 100%;
			height: auto;
			object-fit: cover;
		}

		/* Styling informasi foto di dalam kartu */
		.photo-info {
			padding: 15px;
		}

		.photo-info h5 {
			font-size: 1.2em;
			font-weight: bold;
			margin-bottom: 10px;
		}

		.photo-info p {
			font-size: 0.9em;
			color: #555;
		}

		.photo-actions {
			padding: 10px 15px;
			background-color: #f8f8f8;
			border-top: 1px solid #ddd;
		}

		/* Styling tombol di dalam aksi foto */
		.photo-actions a {
			font-size: 0.9em;
		}


        .btn-primary {
            background-color: rgb(60, 100, 141);
            border: none;
        }

        .btn-danger {
            background-color: rgb(220, 53, 69);
            border: none;
        }

        .search-bar input {
            border: 1px solid #ddd;
            padding: 10px;
            margin-right: 10px;
        }

        .search-bar button {
            background-color: rgb(60, 100, 141);
            color: #fff;
            border: none;
            padding: 10px 15px;
        }
    </style>
</head>

<body>

<!-- Page Preloader -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Offcanvas Menu Section -->
<div class="offcanvas-menu-wrapper">
    <div class="menu-header">
        <a href="./index.php" class="site-logo">
            <img src="img/logo.jpg" alt="" style="max-width: 25vh; height: auto;">
        </a>
        <div class="menu-switch" id="menu-canvas-close">
            <i class="icon_close"></i>
        </div>
    </div>
    <ul class="main-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="gallery.php" class="active">Gallery</a></li>
        <li><a href="dashboard.php">Profile</a></li>
        <li><a href="login.php">Sign In</a></li>
        <li><a href="register.php">Sign Up</a></li>
    </ul>
</div>

<!-- Header section -->
<header class="header-section d-flex align-items-center">
    <a href="./index.php" class="site-logo">
        <img src="img/logo.jpg" alt="" style="max-width: 25vh; height: auto;">
    </a>
    <form action="gallery.php" method="GET" class="search-bar d-flex align-items-center">
        <input type="text" name="query" class="form-control" placeholder="Search..." required>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-search"></i>
        </button>
    </form>
    <div class="menu-switch ml-auto" id="menu-canvas-show">
        <i class="icon_menu"></i>
    </div>
</header>

<!-- Gallery section -->
<section class="gallery-section container py-5">
    <div class="photo-grid">
        <?php
        $searchQuery = isset($_GET['query']) ? mysqli_real_escape_string($con, $_GET['query']) : '';

        $query = "SELECT foto.FotoID, foto.JudulFoto, foto.DeskripsiFoto, foto.TanggalUnggah, foto.LokasiFoto, album.NamaAlbum, user.Username,
                    (SELECT COUNT(*) FROM komentarfoto WHERE FotoID = foto.FotoID) AS jumlah_komentar,
                    (SELECT COUNT(*) FROM likefoto WHERE FotoID = foto.FotoID) AS jumlah_likes
                FROM foto 
                INNER JOIN album ON foto.AlbumID = album.AlbumID 
                INNER JOIN user ON foto.UserID = user.UserID";

        if (!empty($searchQuery)) {
            $query .= " WHERE foto.JudulFoto LIKE '%$searchQuery%' OR 
                            foto.DeskripsiFoto LIKE '%$searchQuery%' OR 
                            album.NamaAlbum LIKE '%$searchQuery%' OR 
                            user.Username LIKE '%$searchQuery%'";
        }

        // Eksekusi query
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Modal untuk menampilkan foto dan detailnya
                echo "
                <div class='photo-card'>
                    <img src='{$row['LokasiFoto']}' alt='{$row['JudulFoto']}' class='card-img-top' data-toggle='modal' data-target='#photoModal{$row['FotoID']}'>
                </div>

                <!-- Modal -->
                <div class='modal fade' id='photoModal{$row['FotoID']}' tabindex='-1' role='dialog' aria-labelledby='photoModalLabel' aria-hidden='true'>
                    <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='photoModalLabel'>{$row['JudulFoto']}</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <img src='{$row['LokasiFoto']}' alt='{$row['JudulFoto']}' class='img-fluid mb-3'>
                                <div class='photo-info'>
                                    <p>{$row['DeskripsiFoto']}</p>
                                    <p><small class='text-muted'>Tanggal: {$row['TanggalUnggah']}</small></p>
                                    <p><small class='text-muted'>Album: {$row['NamaAlbum']}</small></p>
                                    <p><small class='text-muted'>Oleh: {$row['Username']}</small></p>
                                    <p><small class='text-muted'>Likes: {$row['jumlah_likes']} | Comments: {$row['jumlah_komentar']}</small></p>
                                </div>
                                <div class='photo-actions d-flex justify-content-between'>
                                    <a href='edit.php?id={$row['FotoID']}' class='btn btn-primary btn-sm'>Edit</a>
                                    <a href='like.php?id={$row['FotoID']}' class='btn btn-primary btn-sm'>Like</a>
                                    <a href='komentar.php?id={$row['FotoID']}' class='btn btn-primary btn-sm'>Komen</a>
                                    <a href='delete.php?id={$row['FotoID']}' class='btn btn-danger btn-sm'>Delete</a>
									
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p>No photos found matching your search.</p>";
        }
        ?>
    </div>
</section>

	<!-- Modal for Comments -->
	<div class="modal fade" id="commentModal-<?php echo $row['FotoID']; ?>" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="commentModalLabel">Add a Comment</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="comment.php" method="POST">
						<input type="hidden" name="foto_id" value="<?php echo $row['FotoID']; ?>">
						<div class="form-group">
							<label for="comment">Your Comment:</label>
							<textarea class="form-control" name="comment" rows="3" required></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Submit Comment</button>
					</form>
				</div>
			</div>
		</div>
	</div>


<!-- Footer section -->
<footer class="footer-section">
    <div class="footer-social">
        <a href="#">Facebook</a>
        <a href="#">Twitter</a>
        <a href="#">Instagram</a>
    </div>
    <div class="copyright">
        <p>&copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Fransis</a></p>
    </div>
</footer>

<!-- JS Libraries -->
<script src="js/vendor/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script src="js/fresco.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
