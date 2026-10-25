
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$nama = $_SESSION['nama'] ?? 'Pengguna';
$role = $_SESSION['role'] ?? 'petugas';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - FindIt UPIS</title>

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
            background-color: #fff8f8;
            color: #292929;
        }

        .navbar {
            background-color: #d71920;
            padding: 16px 0;
        }

        .navbar-brand {
            color: white;
            font-size: 23px;
            font-weight: 700;
        }

        .navbar-brand:hover {
            color: white;
        }

        .btn-logout {
            background-color: white;
            color: #d71920;
            border: none;
            border-radius: 9px;
            padding: 10px 18px;
            font-weight: 600;
        }

        .btn-logout:hover {
            background-color: #ffe5e5;
            color: #a90f17;
        }

        .main-content {
            max-width: 1450px;
            margin: 44px auto;
            padding: 0 24px;
        }

        .welcome-card {
            background-color: white;
            border: 1px solid #f5dada;
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(150, 0, 0, 0.04);
        }

        .page-title {
            color: #b5121b;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .role-badge {
            display: inline-block;
            background-color: #ffe5e5;
            color: #b5121b;
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 4px;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 20px;
        }

        .menu-card {
            height: 100%;
            background-color: white;
            border: 1px solid #f5dada;
            border-radius: 17px;
            padding: 26px;
            box-shadow: 0 5px 20px rgba(150, 0, 0, 0.04);
        }

        .menu-card h4 {
            color: #b5121b;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .menu-card p {
            color: #666;
            min-height: 48px;
            margin-bottom: 18px;
        }

        .btn-menu {
            display: inline-block;
            background-color: #d71920;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 11px 18px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-menu:hover {
            background-color: #a90f17;
            color: white;
        }

        .footer {
            text-align: center;
            color: #888;
            padding: 28px 15px;
            font-size: 14px;
        }

        @media (max-width: 576px) {
            .main-content {
                margin-top: 25px;
                padding: 0 16px;
            }

            .welcome-card {
                padding: 24px 20px;
            }

            .page-title {
                font-size: 25px;
            }

            .menu-card {
                padding: 22px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="container">

            <a class="navbar-brand" href="dashboard.php">
                FindIt UPIS
            </a>

            <a href="logout.php" class="btn btn-logout">
                Logout
            </a>

        </div>
    </nav>


    <main class="main-content">

        <section class="welcome-card">

            <h1 class="page-title">
                Selamat datang, <?php echo htmlspecialchars(ucfirst($role)); ?> FindIt UPIS!
            </h1>

            <p class="mb-3">
                Sistem informasi untuk membantu pengelolaan laporan barang hilang dan ditemukan.
            </p>

            <span class="role-badge">
                Login sebagai: <?php echo htmlspecialchars($role); ?>
            </span>

        </section>


        <h3 class="section-title">Menu Utama</h3>

        <div class="row g-4">

            <div class="col-md-6 col-lg-4">

                <div class="menu-card">

                    <h4>Daftar Barang</h4>

                    <p>
                        Lihat laporan barang hilang dan barang yang ditemukan.
                    </p>

                    <a href="barang.php" class="btn-menu">
                        Lihat Daftar Barang
                    </a>

                </div>

            </div>


            <div class="col-md-6 col-lg-4">

                <div class="menu-card">

                    <h4>Tambah Barang</h4>

                    <p>
                        Tambahkan laporan barang baru ke dalam sistem.
                    </p>

                    <a href="tambah_barang.php" class="btn-menu">
                        Tambah Barang
                    </a>

                </div>

            </div>


            <?php if ($role === 'admin') { ?>

                <div class="col-md-6 col-lg-4">

                    <div class="menu-card">

                        <h4>Buat Akun Pengguna</h4>

                        <p>
                            Buat akun baru untuk admin atau petugas.
                        </p>

                        <a href="buat_akun.php" class="btn-menu">
                            Buat Akun
                        </a>

                    </div>

                </div>


                <div class="col-md-6 col-lg-4">

                    <div class="menu-card">

                        <h4>Buat Akun Petugas</h4>

                        <p>
                            Buat akun khusus petugas untuk mengelola laporan barang.
                        </p>

                        <a href="buat_petugas.php" class="btn-menu">
                            Buat Akun Petugas
                        </a>
                    </div>
                </div>

            <?php } ?>
        </div>
    </main>
    <footer class="footer">
        FindIt UPIS &copy; 2026
    </footer>
</body>
</html>
 