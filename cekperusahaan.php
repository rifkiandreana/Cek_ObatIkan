<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Data/bpkil.png" type="image/x-icon">
    <title>Pencarian Perusahaan</title>
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
            height: 100vh;
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

        .navbar .logo span {
            font-size: 16px;
            font-weight: bold;
        }

        .navbar .time {
            font-size: 14px;
            font-weight: normal;
        }

        /* Container */
        .container {
            max-width: 800px;
            width: 100%;
            text-align: center;
            margin-top: 80px; /* Memberikan ruang di bawah navbar */
        }

        /* Form Style */
        form label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            text-align: left;
        }
        form input[type="text"],
        select.input-field {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

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
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <img src="Data/bpkil.png" alt="Logo">
            <span>Balai Pengujian Kesehatan ikan dan Lingkungan | Serang</span>
        </div>
        <div class="time" id="time"></div>
    </div>

    <div class="container">
        <h1>Pencarian Data Perusahaan</h1>
        <form action="hasilperusahaan.php" method="get">
            <!-- Kolom Pencarian Utama -->
            <label for="company_name">Nama Perusahaan (Kata Kunci Utama):</label>
            <input type="text" name="main_keyword" id="company_name" placeholder="Masukkan nama perusahaan..." required>

            <!-- Kata Kunci Tambahan -->
            <label for="address">Alamat:</label>
            <input type="text" name="address" id="address" placeholder="Masukkan alamat perusahaan...">

            <label for="provinsi">Provinsi:</label>
            <select name="provinsi" id="provinsi" class="input-field">
                <option value="">Pilih Provinsi...</option>
                <option value="Nanggroe Aceh Darussalam">Nanggroe Aceh Darussalam</option>
                <option value="Sumatera Utara">Sumatera Utara</option>
                <option value="Sumatera Barat">Sumatera Barat</option>
                <option value="Riau">Riau</option>
                <option value="Kepulauan Riau">Kepulauan Riau</option>
                <option value="Jambi">Jambi</option>
                <option value="Bengkulu">Bengkulu</option>
                <option value="Sumatera Selatan">Sumatera Selatan</option>
                <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                <option value="Lampung">Lampung</option>
                <option value="Banten">Banten</option>
                <option value="DKI Jakarta">DKI Jakarta</option>
                <option value="Jawa Barat">Jawa Barat</option>
                <option value="Jawa Tengah">Jawa Tengah</option>
                <option value="DI Yogyakarta">DI Yogyakarta</option>
                <option value="Jawa Timur">Jawa Timur</option>
                <option value="Bali">Bali</option>
                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                <option value="Kalimantan Barat">Kalimantan Barat</option>
                <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                <option value="Kalimantan Timur">Kalimantan Timur</option>
                <option value="Kalimantan Utara">Kalimantan Utara</option>
                <option value="Sulawesi Utara">Sulawesi Utara</option>
                <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                <option value="Sulawesi Barat">Sulawesi Barat</option>
                <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                <option value="Gorontalo">Gorontalo</option>
                <option value="Maluku">Maluku</option>
                <option value="Maluku Utara">Maluku Utara</option>
                <option value="Papua">Papua</option>
                <option value="Papua Barat">Papua Barat</option>
            </select>

            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="footer">
        &copy; <span id="year"></span> Semua Hak Cipta Dilindungi.
    </div>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>
</html>
