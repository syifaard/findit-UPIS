# FindIt UPIS

FindIt UPIS merupakan aplikasi berbasis web yang digunakan untuk mengelola laporan barang hilang dan barang ditemukan di lingkungan kampus. Aplikasi ini dibuat menggunakan PHP dan MySQL dengan bantuan XAMPP sebagai server lokal.

## 1. Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:
- XAMPP
- Visual Studio Code (VS Code)
- Web browser, seperti Google Chrome

## 2. Instalasi Aplikasi

1. Pastikan XAMPP sudah terinstal di komputer.
2. Buka folder instalasi XAMPP, kemudian masuk ke folder `htdocs`.
3. Letakkan folder proyek `finditupis` di dalam folder `htdocs`.

Contoh lokasi folder:

`C:\xampp\htdocs\finditupis`

4. Buka VS Code.
5. Pilih **File → Open Folder**, kemudian pilih folder `finditupis`.
6. Pastikan file PHP aplikasi berada di dalam folder tersebut.

## 3. Konfigurasi Database

1. Buka XAMPP Control Panel.
2. Jalankan layanan **Apache** dan **MySQL**.
3. Buka browser dan akses:

   `http://localhost/phpmyadmin`

4. Buat database baru dengan nama:

   `db_finditupis`

5. Jika tersedia file SQL dari proyek, pilih database `db_finditupis`, kemudian impor file SQL tersebut melalui menu **Import**.
6. Pastikan database memiliki tabel berikut:
   - `users`
   - `kategori_barang`
   - `barang`

7. Buka file `koneksi.php` di VS Code dan pastikan konfigurasi database sesuai dengan pengaturan MySQL lokal.

Contoh konfigurasi:

```php
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_finditupis";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi database gagal.");
}
?>
```

Konfigurasi tersebut menggunakan pengaturan XAMPP standar. Jika username atau password MySQL berbeda, sesuaikan dengan konfigurasi pada komputer yang digunakan.

## 4. Cara Menjalankan Aplikasi

1. Pastikan Apache dan MySQL dalam keadaan aktif di XAMPP Control Panel.
2. Buka browser.
3. Masukkan alamat berikut:

   `http://localhost/finditupis/login.php`

4. Halaman login FindIt UPIS akan ditampilkan.
5. Masukkan username dan password dari akun yang telah dibuat.
6. Setelah berhasil login, pengguna dapat mengakses fitur aplikasi sesuai dengan role yang dimiliki.

## 5. Pembuatan Akun Pengguna

Jika belum memiliki akun, login menggunakan akun admin yang sudah tersedia, kemudian buka halaman **Buat Akun Pengguna** apabila dapat diakses oleh akun tersebut.

Isi nama lengkap, username, password, dan role pengguna. Pilih role **Admin** atau **Petugas**, kemudian klik tombol **Buat Akun**.

Pastikan akun berhasil dibuat sebelum digunakan untuk login.

## 6. Fitur Aplikasi

FindIt UPIS memiliki fitur:
- Login dan logout.
- Pembuatan akun pengguna.
- Menampilkan daftar barang.
- Menambahkan laporan barang hilang atau ditemukan.
- Mengedit data barang.
- Menghapus data barang.
- Mengelola kategori dan status laporan barang.

## 7. Troubleshooting

**Jika aplikasi tidak dapat dibuka:**
- Pastikan Apache sudah aktif.
- Periksa nama folder proyek di dalam `htdocs`.
- Pastikan alamat URL sesuai dengan nama folder.

**Jika koneksi database gagal:**
- Pastikan MySQL sudah aktif.
- Periksa nama database pada `koneksi.php`.
- Periksa username dan password MySQL.
- Pastikan database dan tabel sudah dibuat atau diimpor dengan benar.

**Jika login gagal:**
- Periksa username dan password.
- Pastikan akun sudah tersimpan di tabel `users`.
- Pastikan password sesuai dengan mekanisme penyimpanan password yang digunakan aplikasi.

## 8. Penutup

README ini menjadi panduan instalasi, konfigurasi database, dan penggunaan awal aplikasi FindIt UPIS pada server lokal. Pastikan seluruh file aplikasi dan file SQL yang diperlukan tersedia sebelum aplikasi dijalankan.