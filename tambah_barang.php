<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pesan = "";

$nama_barang = "";
$jenis_laporan = "";
$deskripsi = "";
$lokasi = "";
$tanggal_laporan = date("Y-m-d");
$status = "Belum Selesai";
$id_kategori = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token_post = $_POST['csrf_token'] ?? '';
    $csrf_ok = is_string($token_post)
        && hash_equals($_SESSION['csrf_token'], $token_post);

    $nama_barang = trim($_POST['nama_barang'] ?? "");
    $jenis_laporan = $_POST['jenis_laporan'] ?? "";
    $deskripsi = trim($_POST['deskripsi'] ?? "");
    $lokasi = trim($_POST['lokasi'] ?? "");
    $tanggal_laporan = $_POST['tanggal_laporan'] ?? "";
    $status = $_POST['status'] ?? "Belum Selesai";
    $id_kategori = $_POST['id_kategori'] ?? "";

    if (!$csrf_ok) {

        $pesan = "Permintaan tidak valid. Silakan muat ulang halaman.";

    } elseif (
        $nama_barang === "" ||
        $jenis_laporan === "" ||
        $deskripsi === "" ||
        $lokasi === "" ||
        $tanggal_laporan === "" ||
        $status === "" ||
        $id_kategori === ""
    ) {

        $pesan = "Semua kolom wajib diisi.";

    } elseif (!in_array($jenis_laporan, ['Hilang', 'Ditemukan'], true)) {

        $pesan = "Jenis laporan tidak valid.";

    } elseif (!in_array($status, ['Belum Selesai', 'Selesai'], true)) {

        $pesan = "Status barang tidak valid.";

    } elseif (!ctype_digit((string) $id_kategori)) {

        $pesan = "Kategori barang tidak valid.";

    } else {

        $id_kategori = (int) $id_kategori;

        $cekKategori = mysqli_prepare(
            $conn,
            "SELECT id_kategori FROM kategori_barang WHERE id_kategori = ?"
        );

        mysqli_stmt_bind_param(
            $cekKategori,
            "i",
            $id_kategori
        );

        mysqli_stmt_execute($cekKategori);

        $hasilKategori = mysqli_stmt_get_result($cekKategori);

        if (mysqli_num_rows($hasilKategori) === 0) {

            $pesan = "Kategori barang tidak ditemukan.";

        } else {

            $query = "INSERT INTO barang
                      (nama_barang, jenis_laporan, deskripsi, lokasi,
                       tanggal_laporan, status, id_kategori)
                      VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssi",
                $nama_barang,
                $jenis_laporan,
                $deskripsi,
                $lokasi,
                $tanggal_laporan,
                $status,
                $id_kategori
            );

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);
                mysqli_stmt_close($cekKategori);

                header("Location: barang.php");
                exit;

            } else {

                $pesan = "Data barang gagal ditambahkan.";

            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($cekKategori);
    }
}

$queryKategori = mysqli_query(
    $conn,
    "SELECT * FROM kategori_barang ORDER BY nama_kategori ASC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang - FindIt UPIS</title>

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
            max-width: 800px;
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

        .form-control,
        .form-select {
            border-radius: 9px;
            padding: 11px 13px;
        }

        .form-control:focus,
        .form-select:focus {
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

    <main class="main-content">

        <div class="mb-4">
            <h2 class="page-title">Tambah Laporan Barang</h2>

            <p class="text-secondary">
                Masukkan informasi barang hilang atau barang yang ditemukan.
            </p>
        </div>

        <div class="form-card">

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
                    <label for="nama_barang" class="form-label">
                        Nama Barang
                    </label>

                    <input
                        type="text"
                        name="nama_barang"
                        id="nama_barang"
                        class="form-control"
                        value="<?php echo htmlspecialchars($nama_barang); ?>"
                        placeholder="Contoh: Flashdisk pink"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="jenis_laporan" class="form-label">
                        Jenis Laporan
                    </label>

                    <select
                        name="jenis_laporan"
                        id="jenis_laporan"
                        class="form-select"
                        required
                    >
                        <option value="">Pilih jenis laporan</option>

                        <option
                            value="Hilang"
                            <?php echo $jenis_laporan === 'Hilang' ? 'selected' : ''; ?>
                        >
                            Hilang
                        </option>

                        <option
                            value="Ditemukan"
                            <?php echo $jenis_laporan === 'Ditemukan' ? 'selected' : ''; ?>
                        >
                            Ditemukan
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        id="deskripsi"
                        class="form-control"
                        rows="3"
                        placeholder="Jelaskan ciri-ciri atau kondisi barang"
                        required
                    ><?php echo htmlspecialchars($deskripsi); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">
                        Lokasi
                    </label>

                    <input
                        type="text"
                        name="lokasi"
                        id="lokasi"
                        class="form-control"
                        value="<?php echo htmlspecialchars($lokasi); ?>"
                        placeholder="Contoh: Kantin"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="tanggal_laporan" class="form-label">
                        Tanggal Laporan
                    </label>

                    <input
                        type="date"
                        name="tanggal_laporan"
                        id="tanggal_laporan"
                        class="form-control"
                        value="<?php echo htmlspecialchars($tanggal_laporan); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                        required
                    >
                        <option
                            value="Belum Selesai"
                            <?php echo $status === 'Belum Selesai' ? 'selected' : ''; ?>
                        >
                            Belum Selesai
                        </option>

                        <option
                            value="Selesai"
                            <?php echo $status === 'Selesai' ? 'selected' : ''; ?>
                        >
                            Selesai
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="id_kategori" class="form-label">
                        Kategori Barang
                    </label>

                    <select
                        name="id_kategori"
                        id="id_kategori"
                        class="form-select"
                        required
                    >
                        <option value="">Pilih kategori</option>

                        <?php while ($kategori = mysqli_fetch_assoc($queryKategori)) { ?>

                            <option
                                value="<?php echo $kategori['id_kategori']; ?>"
                                <?php echo (string) $id_kategori === (string) $kategori['id_kategori'] ? 'selected' : ''; ?>
                            >
                                <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                            </option>

                        <?php } ?>

                    </select>
                </div>

                <div class="d-flex flex-wrap gap-2">

                    <button type="submit" class="btn btn-simpan">
                        Simpan Laporan
                    </button>

                    <a href="barang.php" class="btn btn-kembali">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>