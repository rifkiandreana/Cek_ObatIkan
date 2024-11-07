<?php
include 'koneksi.php'; // Menginclude file konfigurasi database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama_obat = $_POST['nama_obat'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat'];
    $provinsi = $_POST['provinsi'];
    $jenis_perusahaan = $_POST['jenis_perusahaan'];
    $nomor_pendaftaran = $_POST['nomor_pendaftaran'];
    $asal_obat = $_POST['asal_obat'];
    $golongan_obat = $_POST['golongan_obat'];
    $bentuk_sediaan = $_POST['bentuk_sediaan'];
    $jenis_sediaan = $_POST['jenis_sediaan'];
    $komposisi = $_POST['komposisi'];
    $indikasi = $_POST['indikasi'];
    $masa_berlaku = $_POST['masa_berlaku'];
    // $masa_berlaku  = (new DateTime($masa_berlaku))->format('d-M-Y');

    // Format tanggal sesuai dengan Y-m-d untuk perhitungan sisa waktu
    $today = new DateTime(); 
    $masa_berlaku_date = new DateTime($masa_berlaku);
    $sisa_waktu = $masa_berlaku_date->diff($today)->days; // Hitung sisa waktu

    // Tentukan status sertifikat
    $status_sertifikat = ($masa_berlaku_date < $today) ? 'Kadaluarsa' : 'Berlaku';

    // Format tanggal sesuai dengan "d-M-Y" (contoh: 15-Jun-2025) untuk penyimpanan
    $masa_berlaku_formatted = $masa_berlaku_date->format('d-M-Y');


    $result = $conn->query("SELECT MAX(`NO`) as last_no FROM obat_ikan");
    $row = $result->fetch_assoc();
    $new_no = $row['last_no'] + 1; // Increment last NO

    
    // Query untuk memasukkan data
    $sql = "INSERT INTO obat_ikan (`NO` ,`NAMA OBAT`, `NAMA PERUSAHAAN`, `ALAMAT`, `PROVINSI`, `JENIS PERUSAHAAN`, `NOMOR PENDAFTARAN`, `ASAL OBAT`, `GOLONGAN OBAT`, `BENTUK SEDIAAN`, `JENIS SEDIAAN`, `KOMPOSISI`, `INDIKASI`, `MASA BERLAKU`, `SISA WAKTU`, `STATUS SERTIFIKAT`)
            VALUES ($new_no,'$nama_obat', '$nama_perusahaan', '$alamat', '$provinsi', '$jenis_perusahaan', '$nomor_pendaftaran', '$asal_obat', '$golongan_obat', '$bentuk_sediaan', '$jenis_sediaan', '$komposisi', '$indikasi', '$masa_berlaku_formatted',  '$sisa_waktu', '$status_sertifikat')";

    if ($conn->query($sql) === TRUE) {
        header("Location: DataObat.php"); // Redirect ke halaman index setelah berhasil
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat Ikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo {
            height: 50px;
        }
        .time {
            font-size: 1em;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 0.9em;
            color: #333;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], select, textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;  /* Make sure padding is included in the element's total width */
        }
        textarea {
            resize: vertical;
            min-height: 50px;
        }
        button {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit'});
            document.getElementById('current-time').textContent = timeString;
        }
        setInterval(updateTime, 1000);
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="Data/bpkil.png" alt="Logo" class="logo">
            <div class="time">Waktu: <span id="current-time"></span></div>
        </div>
        <h2>Tambah Obat Ikan</h2>

            <form method="post">
            <div class="form-grid">
                <div class="form-group">
                    <div>
                        <label for="nama_obat">Nama Obat</label>
                        <input type="text" id="nama_obat" name="nama_obat" required>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="nomor_pendaftaran">Nomor Pendaftaran</label>
                        <input type="text" id="nomor_pendaftaran" name="nomor_pendaftaran" required>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" id="nama_perusahaan" name="nama_perusahaan" required>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" class="resizable" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="provinsi">Provinsi</label>
                        <select name="provinsi" id="provinsi" class="input-field" required>
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
                </div>
                <div class="form-group">
                    <div>
                        <label for="jenis_perusahaan">Jenis Perusahaan</label>
                        <select name="jenis_perusahaan" id="jenis_perusahaan" class="input-field">
                            <option value="">Pilih Jenis Sediaan...</option>
                            <option value="Importir">Importir</option>
                            <option value="Produsen">Produsen</option>
                            <option value="Produsen/Importir">Produsen/Importir</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="asal_obat">Asal Obat</label>
                        <select name="asal_obat" id="asal_obat" class="input-field">
                            <option value="">Pilih Jenis Sediaan...</option>
                            <option value="Dalam Negeri">Dalam Negeri</option>
                            <option value="Impor">Impor</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="golongan_obat">Golongan Obat</label>
                        <select name="golongan_obat" id="golongan_obat" class="input-field">
                            <option value="">Pilih Golongan Obat...</option>
                            <option value="Obat Keras">Obat Keras</option>
                            <option value="Obat Bebas Terbatas">Obat Bebas Terbatas</option>
                            <option value="Obat Bebas">Obat Bebas</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="bentuk_sediaan">Bentuk Sediaan</label>
                        <select name="bentuk_sediaan" id="bentuk_sediaan" class="input-field">
                            <option value="">Pilih Bentuk Sediaan...</option>
                            <option value="Cair">Cair</option>
                            <option value="Kit">Kit</option>
                            <option value="Padat">Padat</option>
                            <option value="Serbuk">Serbuk</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="jenis_sediaan">Jenis Sediaan</label>
                        <select name="jenis_sediaan" id="jenis_sediaan" class="input-field">
                            <option value="">Pilih Jenis Sediaan...</option>
                            <option value="Farmasetik">Farmasetik</option>
                            <option value="Premiks">Premiks</option>
                            <option value="Probiotik">Probiotik</option>
                            <option value="Biologik (Kit Diagnostic)">Biologik (kit diagnostic)</option>
                            <option value="Biologik (Vaksin)">Biologik (vaksin)</option>
                            <option value="Obat Alami/Herbal">Obat alami/herbal</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div>
                        <label for="komposisi">Komposisi</label>
                        <textarea id="komposisi" name="komposisi" class="resizable" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="indikasi">Indikasi</label>
                        <textarea id="indikasi" name="indikasi" class="resizable" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label for="masa_berlaku">Masa Berlaku</label>
                        <input type="date" id="masa_berlaku" name="masa_berlaku" required>
                    </div>
                </div>
                <div>
                        <label>&nbsp;</label> <!-- Empty label for spacing -->
                        <button type="submit">Simpan</button>
                    </div>
            </form>
        </div>
</body>
</html>

