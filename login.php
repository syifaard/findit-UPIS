<?php
session_start();

if (isset($_SESSION['id_user'])) {
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

    $username = trim($_POST['username'] ?? "");
    $password = $_POST['password'] ?? "";

    if (!$csrf_ok) {

        $pesan = "Permintaan tidak valid. Silakan muat ulang halaman.";

    } elseif ($username === "" || $password === "") {

        $pesan = "Username dan password wajib diisi.";

    } else {

        $query = "SELECT id_user, nama, username, password_hash, role
                  FROM users
                  WHERE username = ?";

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $hasil = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($hasil);

        if ($user && password_verify($password, $user['password_hash'])) {

            session_regenerate_id(true);

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            mysqli_stmt_close($stmt);

            header("Location: dashboard.php");
            exit;

        } else {

            $pesan = "Username atau password salah.";

        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - FindIt UPIS</title>

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
            background: linear-gradient(135deg, #fff5f5, #ffe2e2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background-color: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(150, 0, 0, 0.1);
        }

        .logo {
            width: 75px;
            height: 75px;
            background-color: #d71920;
            color: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            font-weight: 700;
            margin: 0 auto 18px;
        }

        .title {
            color: #b5121b;
            font-weight: 700;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 9px;
        }

        .form-control:focus {
            border-color: #d71920;
            box-shadow: 0 0 0 0.2rem rgba(215, 25, 32, 0.12);
        }

        .btn-login {
            width: 100%;
            background-color: #d71920;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 9px;
            font-weight: 600;
        }

        .btn-login:hover {
            background-color: #a90f17;
            color: white;
        }

        .footer-text {
            font-size: 13px;
            color: #777;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 27px 22px;
            }
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="text-center mb-4">

            <div class="logo">
                FI
            </div>

            <h2 class="title">FindIt UPIS</h2>

            <p class="text-secondary mb-0">
                Sistem Informasi Barang Hilang dan Ditemukan
            </p>

        </div>

        <?php if ($pesan !== "") { ?>

            <div class="alert alert-danger">
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
                <label for="username" class="form-label">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control"
                    placeholder="Masukkan username"
                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                    autocomplete="username"
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
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-login">
                Login
            </button>

        </form>

        <div class="text-center mt-4 footer-text">
            FindIt UPIS &copy; 2026
        </div>
    </div>
</body>
</html>