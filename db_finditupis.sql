-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Okt 2026 pada 13.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_finditupis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jenis_laporan` enum('Hilang','Ditemukan') NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` varchar(150) NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `status` enum('Belum Selesai','Selesai') NOT NULL DEFAULT 'Belum Selesai',
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `jenis_laporan`, `deskripsi`, `lokasi`, `tanggal_laporan`, `status`, `id_kategori`) VALUES
(2, 'Kartu mahasiswa', 'Ditemukan', 'Kartu mahasiswa ditemukan di lantai', 'Kantin', '2026-10-23', 'Belum Selesai', 2),
(3, 'Jam tangan', 'Hilang', 'Jam tangan warna hitam', 'Ruang kelas SIK3A', '2026-10-23', 'Selesai', 3),
(8, 'Cardigan', 'Hilang', 'cardigan hilang di kelas', 'Kelas LK4B', '2026-10-25', 'Selesai', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_barang`
--

INSERT INTO `kategori_barang` (`id_kategori`, `nama_kategori`) VALUES
(3, 'Aksesori'),
(4, 'Barang Lainnya'),
(2, 'Dokumen'),
(1, 'Elektronik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','petugas') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password_hash`, `role`, `created_at`) VALUES
(1, 'Admin FindIt UPI', 'admin', '$2y$10$GNaLvIXmisfhxkafiMbOaeQmnfIwKDjRXI4puE0oc/93erT9s.rU2', 'admin', '2026-10-23 17:05:33'),
(2, 'Petugas FindIt UPIS', 'petugas', '$2y$10$bnwbR1ksgr7K23WyzuCWZuDXnCvmvS1I7W5zYN5W8rP2FU22CkU5.', 'petugas', '2026-10-24 21:22:54'),
(3, 'George Russel', 'jorj1632', '$2y$10$HcmP8IPzr55DmzJ6kNvugOjXytbYUiduYPUeryx/n/9sP5UnsorHK', 'admin', '2026-10-25 09:36:54'),
(4, 'Kimi Antonnelli', 'kimi123', '$2y$10$McK6Ilp9ticS1MD39XVFC.a7eNwvOBb49iyQOUWZBBTv.NORPG6eu', 'petugas', '2026-10-25 09:38:49');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_barang` (`id_kategori`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
