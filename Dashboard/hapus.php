<?php
session_start();
include '../koneksi.php'; // Menghubungkan ke database

// Memastikan bahwa parameter 'id' tersedia dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data dari tabel berdasarkan id
    $sql = "DELETE FROM perusahaan WHERE id = $id";

    // Menjalankan query dan memeriksa apakah berhasil
    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, redirect ke halaman index.php
        header("Location: perusahaan.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Jika tidak ada parameter no, tampilkan pesan error
    echo "Tidak ada ID yang diberikan untuk dihapus.";
}

$conn->close(); // Menutup koneksi
?>
