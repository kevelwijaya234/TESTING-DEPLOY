<?php

// 1. Tampilkan error secara visual
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Panel Inisialisasi Database Serverless Vercel</h2>";
echo "Menghubungkan langsung ke server Clever Cloud via PDO Murni...<br>";

// 2. Data Kredensial Asli Clever Cloud Anda
$host     = 'bypaqxd1pk46eezfadm8-mysql.services.clever-cloud.com';
$dbname   = 'bypaqxd1pk46eezfadm8';
$username = 'usbxd0rd7a78tjgj';
// MASUKKAN PASSWORD ASLI CLEVER CLOUD ANDA DI BAWAH INI
$password = 'QieBXTilf3v8yO2Iqdt2';
$port     = 3306;

try {
    // 3. Koneksi PDO dengan pengaturan SSL yang kompatibel untuk Vercel
    $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4";

    // Kita gunakan opsi MYSQL_ATTR_SSL_VERIFY_SERVER_CERT secara murni angka (1014) 
    // atau biarkan driver menegosiasikan SSL secara otomatis tanpa konstan yang merusak
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];

    // Trik mengaktifkan SSL tanpa memicu Undefined Constant
    if (defined('PDO::MYSQL_ATTR_SSL_CA') || defined('1012')) {
        // 1012 adalah kode integer internal PHP untuk MYSQL_ATTR_SSL_CA
        $options[1012] = true;
    }

    $pdo = new PDO($dsn, $username, $password, $options);

    echo "<span style='color:green; font-weight:bold;'>✔ KONEKSI KE CLEVER CLOUD BERHASIL!</span><br><br>";
    echo "Membuat tabel sistem migrasi awal...<br>";

    // 4. Membuat tabel migrasi dasar
    $sql = "CREATE TABLE IF NOT EXISTS migrations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        batch INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "<span style='color:green; font-weight:bold;'>✔ Tabel 'migrations' resmi terbuat di Clever Cloud!</span><br>";

    echo "<h3>Status Akhir:</h3>";
    echo "Database Anda sekarang sudah aktif, aman, dan siap digunakan.";
} catch (PDOException $e) {
    echo "<span style='color:red; font-weight:bold;'>❌ KONEKSI GAGAL! Terjadi kendala:</span><br>";
    echo "<h3>Pesan Error PHP:</h3>";
    echo "<pre style='background:#fff0f0; padding:10px; border:1px solid #ffa0a0; color:red;'>" . $e->getMessage() . "</pre>";
}
