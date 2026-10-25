<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

include 'koneksi.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token_post = $_POST['csrf_token'] ?? '';
    $csrf_ok = is_string($token_post)
        && hash_equals($_SESSION['csrf_token'], $token_post);

    $nama = trim($_POST['nama'] ?? "");
    $username = trim($_POST['username'] ?? "");
    $password = $_POST['password'] ?? "";

    if (!$csrf_ok) {

        $pesan = "Permintaan tidak valid. Silakan muat ulang halaman.";

    } elseif ($nama === "" || $username === "" || $password === "") {

        $pesan = "Semua kolom wajib diisi.";

    } elseif (strlen($password) < 6) {

        $pesan = "Password minimal 6 karakter.";

    } else {

        $cek = mysqli_prepare(
            $conn,
            "SELECT id_user FROM users WHERE username = ?"
        );

        mysqli_stmt_bind_param($cek, "s", $username);
        mysqli_stmt_execute($cek);

        $hasil = mysqli_stmt_get_result($cek);

        if (mysqli_num_rows($hasil) > 0) {

            $pesan = "Username sudah digunakan.";

        } else {

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $role = "petugas";

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users (nama, username, password_hash, role)
                 VALUES (?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $nama,
                $username,
                $passwordHash,
                $role
            );

            if (mysqli_stmt_execute($stmt)) {

                $pesan = "Akun petugas berhasil dibuat.";

            } else {

                $pesan = "Akun petugas gagal dibuat.";

            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($cek);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Akun Petugas - FindIt UPIS</title>

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
            font-size: 22px;
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
            padding: 9px 17px;
        }

        .main-content {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 18px;
        }

        .form-card {
            background-color: white;
            border: 1px solid #f3dede;
            border-radius: 17px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(150, 0, 0, 0.06);
        }

        .page-title {
            color: #a90f17;
            font-weight: 700;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 9px;
            padding: 11px 13px;
        }

        .form-control:focus {
            border-color: #d71920;
            box-shadow: 0 0 0 0.2rem rgba(215, 25, 32, 0.12);
        }

        .btn-simpan {
            background-color: #d71920;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 11px 20px;
        }

        .btn-simpan:hover {
            background-color: #a90f17;
            color: white;
        }

        .btn-kembali {
            background-color: #eeeeee;
            color: #333;
            border: none;
            border-radius: 9px;
            padding: 11px 20px;
        }

        @media (max-width: 576px) {
            .form-card {
                padding: 22px 17px;
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

    <div class="main-content">

        <div class="mb-4">
            <h2 class="page-title">Buat Akun Petugas</h2>

            <p class="text-secondary">
                Tambahkan petugas agar dapat mengelola laporan barang.
            </p>
        </div>

        <div class="form-card">

            <?php if ($pesan !== "") { ?>

                <div class="alert alert-info">
                    <?php echo htmlspecialchars($pesan); ?>
                </div>

            <?php } ?>

            <form method="POST" action="">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
                >

                <div class="mb-3">
                    <label for="nama" class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        class="form-control"
                        value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="form-control"
                        value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        minlength="6"
                        required
                    >

                    <small class="text-secondary">
                        Password minimal 6 karakter.
                    </small>
                </div>

                <div class="d-flex flex-wrap gap-2">

                    <button type="submit" class="btn btn-simpan">
                        Buat Akun Petugas
                    </button>

                    <a href="dashboard.php" class="btn btn-kembali">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>