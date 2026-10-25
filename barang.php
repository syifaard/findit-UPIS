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

$role = $_SESSION['role'];

$query = "SELECT barang.*, kategori_barang.nama_kategori
          FROM barang
          JOIN kategori_barang
          ON barang.id_kategori = kategori_barang.id_kategori
          ORDER BY barang.id_barang ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Barang - FindIt UPIS</title>

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
            margin: 0;
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
            font-weight: 600;
        }

        .btn-logout:hover {
            background-color: #ffe5e5;
            color: #a90f17;
        }

        .main-content {
            padding: 35px 0;
        }

        .page-title {
            color: #a90f17;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .role-info {
            margin-bottom: 22px;
            color: #666;
        }

        .table-card {
            background-color: white;
            border: 1px solid #f3dede;
            border-radius: 15px;
            padding: 20px;
            margin-top: 25px;
            box-shadow: 0 5px 18px rgba(150, 0, 0, 0.05);
        }

        .table thead th {
            background-color: #d71920;
            color: white;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .btn-tambah {
            background-color: #d71920;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 10px 17px;
        }

        .btn-tambah:hover {
            background-color: #a90f17;
            color: white;
        }

        .btn-dashboard {
            background-color: #eeeeee;
            color: #333;
            border: none;
            border-radius: 9px;
            padding: 10px 17px;
        }

        .btn-dashboard:hover {
            background-color: #dddddd;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #292929;
            border: none;
            border-radius: 7px;
            padding: 6px 12px;
            text-decoration: none;
        }

        .btn-hapus {
            background-color: #d71920;
            color: white;
            border: none;
            border-radius: 7px;
            padding: 6px 12px;
        }

        .btn-hapus:hover {
            background-color: #a90f17;
            color: white;
        }

        .modal-content {
            border: none;
            border-radius: 15px;
        }

        .modal-header {
            background-color: #d71920;
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .empty-message {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 22px 12px;
            }

            .table-card {
                padding: 12px;
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

    <div class="container main-content">

        <h2 class="page-title">
            Daftar Barang
        </h2>

        <p class="role-info">
            Login sebagai:
            <strong>
                <?php echo htmlspecialchars($role); ?>
            </strong>
        </p>

        <div class="d-flex flex-wrap gap-2">

            <a href="tambah_barang.php" class="btn btn-tambah">
                + Tambah Barang
            </a>

            <a href="dashboard.php" class="btn btn-dashboard">
                Kembali ke Dashboard
            </a>

        </div>

        <div class="table-card">

            <div class="table-responsive">

                <table class="table table-bordered table-striped mb-0">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Jenis Laporan</th>
                            <th>Deskripsi</th>
                            <th>Lokasi</th>
                            <th>Tanggal Laporan</th>
                            <th>Status</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($result && mysqli_num_rows($result) > 0) { ?>

                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                                <tr>
                                    <td>
                                        <?php echo $row['id_barang']; ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['nama_barang']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['jenis_laporan']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['deskripsi']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['lokasi']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['tanggal_laporan']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($row['nama_kategori']); ?>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">

                                            <a
                                                href="edit_barang.php?id=<?php echo $row['id_barang']; ?>"
                                                class="btn-edit"
                                            >
                                                Edit
                                            </a>

                                            <?php if ($role === 'admin') { ?>

                                                <form
                                                    action="hapus_barang.php"
                                                    method="POST"
                                                    class="form-hapus"
                                                >

                                                    <input
                                                        type="hidden"
                                                        name="csrf_token"
                                                        value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="id_barang"
                                                        value="<?php echo $row['id_barang']; ?>"
                                                    >

                                                    <button
                                                        type="submit"
                                                        name="hapus"
                                                        class="btn btn-hapus"
                                                    >
                                                        Hapus
                                                    </button>

                                                </form>

                                            <?php } ?>

                                        </div>
                                    </td>
                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="9" class="empty-message">
                                    Belum ada data barang yang dilaporkan.
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="modalHapus"
        tabindex="-1"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Konfirmasi Hapus
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>
                </div>

                <div class="modal-body">
                    Apakah kamu yakin ingin menghapus laporan barang ini?
                    Data yang dihapus tidak dapat dikembalikan.
                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        class="btn btn-danger"
                        id="konfirmasiHapus"
                    >
                        Ya, Hapus
                    </button>

                </div>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const modalHapus = document.getElementById('modalHapus');

        const konfirmasiHapus = document.getElementById('konfirmasiHapus');

        const modal = new bootstrap.Modal(modalHapus);

        let formYangDihapus = null;

        document.querySelectorAll('.form-hapus').forEach(function(form) {

            form.addEventListener('submit', function(event) {

                event.preventDefault();

                formYangDihapus = form;

                modal.show();

            });

        });

        konfirmasiHapus.addEventListener('click', function() {

            if (formYangDihapus !== null) {

                formYangDihapus.submit();

            }

        });
    </script>

</body>
</html>