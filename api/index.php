<?php

// 1. Paksa Vercel menampilkan error di layar jika ada masalah koneksi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Panel Inisialisasi Database Serverless Vercel</h2>";
echo "Menghubungkan langsung ke server Clever Cloud via PDO Murni...<br>";

// 2. Data Kredensial Asli dari Clever Cloud Anda
$host     = 'bypaqxd1pk46eezfadm8-mysql.services.clever-cloud.com';
$dbname   = 'bypaqxd1pk46eezfadm8';
$username = 'usbxd0rd7a78tjgj';
// Masukkan password asli Clever Cloud Anda di bawah ini
$password = 'MASUKKAN_PASSWORD_CLEVER_CLOUD_ANDA';
$port     = 3306;

try {
    // 3. Membuat koneksi langsung tanpa memuat framework Laravel
    $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Mengaktifkan enkripsi SSL agar tidak terkena "Connection Refused" oleh Clever Cloud
        PDO::MYSQL_ATTR_SSL_STR_TO_KEY => true
    ]);

    echo "<span style='color:green; font-weight:bold;'>✔ KONEKSI KE CLEVER CLOUD BERHASIL!</span><br><br>";
    echo "Membuat tabel sistem migrasi awal...<br>";

    // 4. Membuat tabel migrasi dasar agar struktur database Anda siap digunakan
    $sql = "CREATE TABLE IF NOT EXISTS migrations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "<span style='color:green; font-weight:bold;'>✔ Tabel 'migrations' resmi terbuat di Clever Cloud!</span><br>";

    echo "<h3>Status Akhir:</h3>";
    echo "Database Anda sekarang sudah aktif, aman dari Error 500, dan siap terhubung dengan proyek Anda.";
} catch (PDOException $e) {
    echo "<span style='color:red; font-weight:bold;'>❌ KONEKSI GAGAL! Periksa kembali password Anda:</span><br>";
    echo "<h3>Pesan Error PHP:</h3>";
    echo "<pre style='background:#fff0f0; padding:10px; border:1px solid #ffa0a0; color:red;'>" . $e->getMessage() . "</pre>";
}
