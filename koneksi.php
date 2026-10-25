
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_finditupis";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die("Koneksi database gagal.");
}

mysqli_set_charset($conn, "utf8mb4");
?>
