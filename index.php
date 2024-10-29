<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            font-family: Arial, sans-serif;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
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
            margin: 0 auto;
            padding: 20px;
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
        }
        /* CSS untuk menyamakan ukuran input dan select */
        .input-field {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        #main_keyword {
            font-size: 1.2em;
            padding: 12px;
            margin-bottom: 20px;
        }
        
        /* Grid for Additional Filters */
        .additional-filters {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
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
            <span>Balai Pengujian Kesehatan ikan dan Lingkungan | Serang</span>
        </div>
        <div class="time" id="time"></div>
    </div>

    <!-- Container -->
    <div class="container">
        <h1>Pencarian Data Obat Ikan</h1>
        <form action="hasil.php" method="get">
            <!-- Kolom Pencarian Utama -->
            <label for="main_keyword">Cari Berdasarkan Nama Obat atau Nomor Pendaftaran:</label>
            <input type="text" name="main_keyword" id="main_keyword" placeholder="Masukkan nama obat atau nomor pendaftaran..."><br>

            <!-- Kolom Filter Tambahan -->
            <div class="additional-filters">
                <div>
                    <label for="komposisi">Komposisi:</label>
                    <input type="text" name="komposisi" id="komposisi" placeholder="Masukkan komposisi...">
                </div>
                <div>
                    <label for="indikasi">Indikasi:</label>
                    <input type="text" name="indikasi" id="indikasi" placeholder="Masukkan indikasi...">
                </div>
                <div>
                    <label for="nama_perusahaan">Nama Perusahaan:</label>
                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" placeholder="Masukkan nama perusahaan...">
                </div>
                <div>
                    <label for="golongan_obat">Golongan Obat:</label>
                    <select name="golongan_obat" id="golongan_obat" class="input-field">
                        <option value="">Pilih Golongan Obat...</option>
                        <option value="Obat Keras">Obat Keras</option>
                        <option value="Obat Bebas Terbatas">Obat Bebas Terbatas</option>
                        <option value="Obat Bebas">Obat Bebas</option>
                    </select>
                </div>

                <div>
                    <label for="bentuk_sediaan">Bentuk Sediaan:</label>
                    <select name="bentuk_sediaan" id="bentuk_sediaan" class="input-field">
                        <option value="">Pilih Bentuk Sediaan...</option>
                        <option value="Cair">Cair</option>
                        <option value="Kit">Kit</option>
                        <option value="Padat">Padat</option>
                        <option value="Serbuk">Serbuk</option>
                    </select>
                </div>
                <div>
                    <label for="jenis_sediaan">Jenis Sediaan:</label>
                    <select name="jenis_sediaan" id="jenis_sediaan" class="input-field">
                        <option value="">Pilih Jenis Sediaan...</option>
                        <option value="Farmasetik">Farmasetik</option>
                        <option value="Premiks">Premiks</option>
                        <option value="Probiotik">Probiotik</option>
                        <option value="Biologik (kit diagnostic)">Biologik (kit diagnostic)</option>
                        <option value="Biologik (vaksin)">Biologik (vaksin)</option>
                        <option value="Obat alami/herbal">Obat alami/herbal</option>
                    </select>
                </div>
                <div>
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
                        <option value="Papua Tengah">Papua Tengah</option>
                        <option value="Papua Pegunungan">Papua Pegunungan</option>
                        <option value="Papua Selatan">Papua Selatan</option>
                        <option value="Papua Barat Daya">Papua Barat Daya</option>
                    </select>
                </div>
                <div>
                    <label for="status_sertifikat">Status Sertifikat:</label>
                    <select name="status_sertifikat" id="status_sertifikat" class="input-field">
                        <option value="">Pilih Jenis Sediaan...</option>
                        <option value="Berlaku">Berlaku</option>
                        <option value="Kadaluarsa">Kadaluarsa</option>
                    </select>
                </div>
            </div>

            <button type="submit">Cari</button>
        </form>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; <?php echo date("Y"); ?> Semua Hak Cipta Dilindungi.
    </div>
</body>
</html>
