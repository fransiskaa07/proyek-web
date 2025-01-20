<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaLengkap = mysqli_real_escape_string($con, $_POST['NamaLengkap']);
    $username = mysqli_real_escape_string($con, $_POST['Username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['Password']);
    $alamat = mysqli_real_escape_string($con, $_POST['Alamat']);

    $cekQuery = "SELECT * FROM user WHERE Username = '$username' OR email = '$email'";
    $cekResult = mysqli_query($con, $cekQuery);

    if (mysqli_num_rows($cekResult) > 0) {
        echo "Username atau email sudah digunakan. Silakan coba yang lain.";
    } else {
        $hashedPassword = md5($password);

        $query = "INSERT INTO user (NamaLengkap, Username, email, Password, Alamat) 
                  VALUES ('$namaLengkap', '$username', '$email', '$hashedPassword', '$alamat')";

        if (mysqli_query($con, $query)) {
            echo "Pendaftaran berhasil! Silakan <a href='login.php'>Login</a>.";
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($con);
        }
    }
} else {
    echo "Metode tidak valid.";
}
header("Location: login.php")
?>
