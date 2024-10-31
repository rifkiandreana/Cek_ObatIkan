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
            background-color: #009688;
            margin: 0;
            padding: 20px;

        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-container {
            max-width: 800px; /* Max width for the form */
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        .form-row > div {
            flex: 1; /* Take equal space */
            margin-right: 10px;
        }
        .form-row > div:last-child {
            margin-right: 0; /* Remove margin from the last column */
        }
        input[type="text"],
        input[type="date"],
        select,
        button {
            width: 100%; /* Ensure full width within columns */
            padding: 8px; /* Maintain padding */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        /* Adjust styles for resizable text areas */
        .resizable {
            resize: both; /* Allow resizing both vertically and horizontally */
            overflow: auto; /* Add scroll if needed */
            min-height: 40px; /* Minimum height */
            height: 40px; /* Default height */
            min-width: 80%; /* Minimum width */
            max-width: 100%; /* Prevent it from exceeding container */
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px; /* Add margin on top for spacing */
        }
        button:hover {
            background-color: #218838;
        }
        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Tambah Obat Ikan</h2>
    <div class="form-container">
        <form method="post">
            <div class="form-row">
                <div>
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" id="nama_obat" name="nama_obat" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="nomor_pendaftaran">Nomor Pendaftaran</label>
                    <input type="text" id="nomor_pendaftaran" name="nomor_pendaftaran" required>
                </div>
                <div>
                    <label for="nama_perusahaan">Nama Perusahaan</label>
                    <input type="text" id="nama_perusahaan" name="nama_perusahaan" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="resizable" required></textarea>
                </div>
            </div>
            <div class="form-row">
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
            <div class="form-row">
                <div>
                    <label for="asal_obat">Asal Obat</label>
                    <select name="asal_obat" id="asal_obat" class="input-field">
                        <option value="">Pilih Jenis Sediaan...</option>
                        <option value="Dalam Negeri">Dalam Negeri</option>
                        <option value="Impor">Impor</option>
                    </select>
                </div>
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
            <div class="form-row">
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
                <div>
                    <label for="jenis_sediaan">Jenis Sediaan</label>
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
            </div>
            <div class="form-row">
                <div>
                    <label for="komposisi">Komposisi</label>
                    <textarea id="komposisi" name="komposisi" class="resizable" required></textarea>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="indikasi">Indikasi</label>
                    <textarea id="indikasi" name="indikasi" class="resizable" required></textarea>
                </div>
            </div>
            <div class="form-row">
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

