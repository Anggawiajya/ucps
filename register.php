<?php
// Tampilkan semua kesalahan (untuk debugging selama pengembangan)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi database
$servername = "23.88.73.88"; // Biasanya di-hosting, gunakan 'localhost' atau '127.0.0.1'
$username = "u2512926_6d8IM6SwZp";
$password = "xIdY9nT!Q9Lf+sI!sE9xv5TG";
$dbname = "s2512926_ucp";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menangkap data dari form dan sanitasi input
$ucp = $conn->real_escape_string($_POST['ucp']);
$verifycode = $conn->real_escape_string($_POST['verifycode']);
$DiscordID = $conn->real_escape_string($_POST['DiscordID']);

// Hashing password dengan salt
$salt = bin2hex(random_bytes(8)); // Membuat salt acak
$hashed_password = hash('sha256', $password . $salt); // Hashing password dengan SHA-256

// Query untuk insert data ke database
$sql = "INSERT INTO playerucp (ucp, verifycode, DiscordID, password, salt) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $ucp, $verifycode, $DiscordID, $hashed_password, $salt);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>