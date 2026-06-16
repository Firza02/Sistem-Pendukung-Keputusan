<?php
$host = "localhost:3306";
$user = "root";
$pass = "";
$db   = "spksaw";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
