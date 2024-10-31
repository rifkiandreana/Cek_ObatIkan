<?php
include 'koneksi.php'; // Menghubungkan ke database

// Memastikan bahwa parameter 'no' tersedia dalam URL
if (isset($_GET['no'])) {
    $no = $_GET['no'];

    // Query untuk menghapus data dari tabel berdasarkan NO
    $sql = "DELETE FROM obat_ikan WHERE NO = $no";

    // Menjalankan query dan memeriksa apakah berhasil
    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, redirect ke halaman index.php
        header("Location: DataObat.php");
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
