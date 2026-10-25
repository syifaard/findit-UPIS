<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: barang.php");
    exit;
}

include 'koneksi.php';

$token_post = $_POST['csrf_token'] ?? '';
$csrf_ok = isset($_SESSION['csrf_token'])
    && is_string($token_post)
    && hash_equals($_SESSION['csrf_token'], $token_post);

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    $csrf_ok &&
    isset($_POST['hapus'], $_POST['id_barang']) &&
    ctype_digit($_POST['id_barang'])
) {
    $id_barang = (int) $_POST['id_barang'];

    $query = "DELETE FROM barang WHERE id_barang = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_barang);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

header("Location: barang.php");
exit;
?>