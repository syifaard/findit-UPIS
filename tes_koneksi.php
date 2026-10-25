
<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tes Koneksi - FindIt UPIS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .status-card {
            width: 100%;
            max-width: 500px;
            background-color: white;
            border: 1px solid #f3dede;
            border-radius: 18px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(150, 0, 0, 0.08);
        }

        .status-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .title {
            color: #b5121b;
            font-weight: 700;
        }

        .btn-kembali {
            background-color: #d71920;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 11px 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-kembali:hover {
            background-color: #a90f17;
            color: white;
        }
    </style>
</head>

<body>

    <div class="status-card">

        <div class="status-icon">
            ✅
        </div>

        <h2 class="title">FindIt UPIS</h2>

        <h5 class="mt-3">Koneksi Database Berhasil</h5>

        <p class="text-secondary mt-3">
            PHP berhasil terhubung dengan database
            <strong>db_finditupis</strong>.
        </p>

        <a href="login.php" class="btn-kembali mt-3">
            Kembali ke Login
        </a>
    </div>
</body>
</html>
