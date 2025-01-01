<?php
session_start();
include '../koneksi.php'; // Pastikan koneksi database benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan sanitasi input menggunakan mysqli_real_escape_string
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $provinsi = mysqli_real_escape_string($conn, $_POST['provinsi']);

    // Validasi input
    if (empty($nama_perusahaan) || empty($alamat) || empty($provinsi)) {
        echo "<script>alert('Semua kolom harus diisi!');</script>";
    } else {
        // Query untuk menyimpan data dengan prepared statement untuk mencegah SQL Injection
        $sql = "INSERT INTO perusahaan (`NAMA PERUSAHAAN`, ALAMAT, PROVINSI) VALUES (?, ?, ?)";
        
        // Menyiapkan statement
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Binding parameter dengan prepared statement
            $stmt->bind_param("sss", $nama_perusahaan, $alamat, $provinsi);
            
            // Eksekusi query
            if ($stmt->execute()) {
                // Redirect langsung ke halaman perusahaan.php
                header("Location: perusahaan.php");
                exit; // Pastikan script tidak dilanjutkan setelah redirect
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Perusahaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f9;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 0.9em;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: inline-block;
            background-color:rgb(255, 0, 0); /* Warna merah */
            color: white; /* Warna teks */
            padding: 10px ; /* Padding untuk tombol */
            text-align: center; /* Pusatkan teks */
            text-decoration: none; /* Hilangkan garis bawah */
            border-radius: 5px; /* Sudut tombol melengkung */
            border: none; /* Hilangkan border */
            font-size: 1em; /* Ukuran font */
            cursor: pointer; /* Ubah kursor menjadi pointer */
            margin-top: 25px;
        }

        .back-link:hover {
            background-color:rgb(255, 106, 106); /* Warna saat hover */
        }
        .back-link a {
            color:rgb(255, 255, 255);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Data Perusahaan</h2>
        <form method="post" action="add.php">
            <div class="form-group">
                <label for="nama_perusahaan">Nama Perusahaan</label>
                <input type="text" id="nama_perusahaan" name="nama_perusahaan" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select name="provinsi" id="provinsi" required>
                    <option value="">Pilih Provinsi...</option>
                    <option value="Aceh">Aceh</option>
                    <option value="Sumatera Utara">Sumatera Utara</option>
                    <option value="Jawa Barat">Jawa Barat</option>
                    <option value="Jawa Tengah">Jawa Tengah</option>
                    <option value="Jawa Timur">Jawa Timur</option>
                    <option value="Bali">Bali</option>
                    <option value="Papua">Papua</option>
                    <!-- Tambahkan provinsi lainnya -->
                </select>
            </div>
            <button type="submit">Simpan Data</button>
        </form>
        <div>
            <div class="back-link">
                <a href="perusahaan.php">Kembali Daftar Perusahaan</a>
            </div>
        </div>
    </div>
</body>
</html>
