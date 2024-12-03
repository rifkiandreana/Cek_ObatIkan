<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Data/bpkil.png" type="image/x-icon">
    <title>Pencarian Obat Ikan</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #e0f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Tinggi penuh layar */
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar .logo img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar .time {
            font-size: 1em;
        }

        /* Container */
        .container {
            max-width: 800px;
            width: 100%;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }

        /* Form Style */
        form label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            text-align: left;
        }
        form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            height: 5rem;
            font-size: 1rem;
        }
        /* Submit Button */
        button[type="submit"] {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 20px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Footer */
        .footer {
            background-color: #00796b;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        
        .btn-kembali {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            position: absolute;
            top: 60px; /* Posisi di bawah navbar */
            left: 10px; /* Berada di kiri */
        }
        .btn-kembali a {
            color: white;
            text-decoration: none;
        }
        .btn-kembali:hover {
            background-color: blue; /* Warna hover */
        }
    </style>

    <script>
        // Fungsi untuk menampilkan tanggal dan waktu
        function showDateTime() {
            const timeElement = document.getElementById("time");
            const now = new Date();
            
            // Format tanggal dan waktu
            const tanggal = now.toLocaleDateString("id-ID", { day: '2-digit', month: 'long', year: 'numeric' });
            const waktu = now.toLocaleTimeString("id-ID", { hour: '2-digit', minute: '2-digit' });
            
            // Tampilkan tanggal dan waktu
            timeElement.textContent = `${tanggal} ${waktu}`;
        }
        
        setInterval(showDateTime, 1000);  // Update tanggal dan waktu setiap detik
    </script>

</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <img src="Data/bpkil.png" alt="Logo"> <!-- Ganti dengan path logo -->
            <span>Balai Pengujian Kesehatan Ikan dan Lingkungan | Serang</span>
        </div>
        <div class="time" id="time"></div>
    </div>

    <button type="submit" class="btn-kembali">
             <a href="index.php">Kembali</a>
    </button>

    <!-- Container -->
    <div class="container">
        <h1>Pencarian Merk dan Registrasi Obat Ikan</h1>
        <form action="hasil.php" method="get">
            <!-- Kolom Pencarian Utama -->
            <label for="main_keyword">Cari Berdasarkan Nama Obat atau Nomor Pendaftaran:</label>
            <input type="text" name="main_keyword" id="main_keyword" placeholder="Masukkan nama obat atau nomor pendaftaran..."><br>

            <button type="submit">Cari</button>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; <span id="year"></span> Semua Hak Cipta Dilindungi.
    </div>

    <script>
        // Menampilkan tahun saat ini di footer
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>
</html>
