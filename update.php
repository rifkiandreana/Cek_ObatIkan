<?php
include 'koneksi.php';

$no = $_GET['no'];

// Ambil data dari database berdasarkan ID
$result = $conn->query("SELECT * FROM obat_ikan WHERE NO=$no");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $no = $_GET['no'];
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

    // Format tanggal ke d-M-Y sebelum disimpan
    $masa_berlaku_date = new DateTime($masa_berlaku);
    $masa_berlaku_formatted = $masa_berlaku_date->format('d-M-Y');

    // Hitung sisa waktu dan status sertifikat
    $today = new DateTime();
    $sisa_waktu = $masa_berlaku_date->diff($today)->days;
    $status_sertifikat = ($masa_berlaku_date < $today) ? 'Kadaluarsa' : 'Berlaku';
    

    // Update data di database
    $sql = "UPDATE obat_ikan SET 
            `NAMA OBAT`='$nama_obat', 
            `NAMA PERUSAHAAN`='$nama_perusahaan', 
            `ALAMAT`='$alamat', 
            `PROVINSI`='$provinsi', 
            `JENIS PERUSAHAAN`='$jenis_perusahaan', 
            `NOMOR PENDAFTARAN`='$nomor_pendaftaran', 
            `ASAL OBAT`='$asal_obat', 
            `GOLONGAN OBAT`='$golongan_obat', 
            `BENTUK SEDIAAN`='$bentuk_sediaan', 
            `JENIS SEDIAAN`='$jenis_sediaan', 
            `KOMPOSISI`='$komposisi', 
            `INDIKASI`='$indikasi', 
            `MASA BERLAKU`='$masa_berlaku_formatted',
            `SISA WAKTU`='$sisa_waktu',
            `STATUS SERTIFIKAT`='$status_sertifikat'
        WHERE `NO`=$no";
            

    if ($conn->query($sql) === TRUE) {
        header("Location: DataObat.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function formatDate($date) {
    return date('d-M-Y', strtotime($date));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat Ikan</title>
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
        <h2>Edit Obat Ikan</h2>
        <form method="post">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Obat:</label>
                    <input type="text" name="nama_obat" value="<?= htmlspecialchars($row['NAMA OBAT']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Nama Perusahaan:</label>
                    <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($row['NAMA PERUSAHAAN']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Nomor Pendaftaran:</label>
                    <input type="text" name="nomor_pendaftaran" value="<?= htmlspecialchars($row['NOMOR PENDAFTARAN']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Provinsi:</label>
                    <select name="provinsi" class="input-field" required>
                        <option value="">Pilih Provinsi...</option>
                        <?php
                        $provinsi_list = [
                            "Nanggroe Aceh Darussalam", "Sumatera Utara", "Sumatera Barat", "Riau", "Kepulauan Riau", 
                            "Jambi", "Bengkulu", "Sumatera Selatan", "Kepulauan Bangka Belitung", "Lampung", 
                            "Banten", "DKI Jakarta", "Jawa Barat", "Jawa Tengah", "DI Yogyakarta", 
                            "Jawa Timur", "Bali", "Nusa Tenggara Barat", "Nusa Tenggara Timur", 
                            "Kalimantan Barat", "Kalimantan Tengah", "Kalimantan Selatan", "Kalimantan Timur", 
                            "Kalimantan Utara", "Sulawesi Utara", "Sulawesi Tengah", "Sulawesi Selatan", 
                            "Sulawesi Barat", "Sulawesi Tenggara", "Gorontalo", "Maluku", "Maluku Utara", 
                            "Papua", "Papua Barat", "Papua Tengah", "Papua Pegunungan", 
                            "Papua Selatan", "Papua Barat Daya"
                        ];
                        foreach ($provinsi_list as $provinsi) {
                            $selected = ($row['PROVINSI'] == $provinsi) ? 'selected' : '';
                            echo "<option value=\"$provinsi\" $selected>$provinsi</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Jenis Perusahaan:</label>
                    <select name="jenis_perusahaan" class="input-field" required>
                        <option value="">Pilih Jenis Perusahaan...</option>
                        <?php
                        $jenis_perusahaan_list = [
                            "Importir", "Produsen", "Produsen/Importir"
                        ];
                        foreach ($jenis_perusahaan_list as $jenis_perusahaan) {
                            $selected = ($row['JENIS PERUSAHAAN'] == $jenis_perusahaan) ? 'selected' : '';
                            echo "<option value=\"$jenis_perusahaan\" $selected>$jenis_perusahaan</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Asal Obat:</label>
                    <select name="asal_obat" class="input-field" required>
                        <option value="">Pilih Asal Obat...</option>
                        <?php
                        $asal_obat_list = [
                            "Impor", "Dalam Negeri", 
                        ];
                        foreach ($asal_obat_list as $asal_obat) {
                            $selected = ($row['ASAL OBAT'] == $asal_obat) ? 'selected' : '';
                            echo "<option value=\"$asal_obat\" $selected>$asal_obat</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Golongan Obat:</label>
                    <select name="golongan_obat" class="input-field" required>
                        <option value="">Pilih Golongan Obat...</option>
                        <?php
                        $golongan_obat_list = [
                            "Obat Bebas", "Obat Bebas Terbatas", "Obat Keras" 
                        ];
                        foreach ($golongan_obat_list as $golongan_obat) {
                            $selected = ($row['GOLONGAN OBAT'] == $golongan_obat) ? 'selected' : '';
                            echo "<option value=\"$golongan_obat\" $selected>$golongan_obat</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Bentuk Sediaan:</label>
                    <select name="bentuk_sediaan" class="input-field" required>
                        <option value="">Pilih Bentuk Sediaan...</option>
                        <?php
                        $bentuk_sediaan_list = [
                            "Cair", "Kit", "Padat", "Serbuk" 
                        ];
                        foreach ($bentuk_sediaan_list as $bentuk_sediaan) {
                            $selected = ($row['BENTUK SEDIAAN'] == $bentuk_sediaan) ? 'selected' : '';
                            echo "<option value=\"$bentuk_sediaan\" $selected>$bentuk_sediaan</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Jenis Sediaan:</label>
                    <select name="jenis_sediaan" class="input-field" required>
                        <option value="">Pilih Jenis Sediaan...</option>
                        <?php
                        $jenis_Sediaan_list = [
                            "Farmasetik",
                            "Premiks",
                            "Probiotik",
                            "Biologik (Kit diagnostic)",
                            "Biologik (Vaksin)",
                            "Obat Alami/Herbal",
                        ];
                        foreach ($jenis_Sediaan_list as $jenis_sediaan) {
                            $selected = ($row['JENIS SEDIAAN'] == $jenis_sediaan) ? 'selected' : '';
                            echo "<option value=\"$jenis_sediaan\" $selected>$jenis_sediaan</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alamat:</label>
                    <textarea name="alamat" required><?= htmlspecialchars($row['ALAMAT']) ?></textarea>
                </div>
                <div class="form-group">
                    <label>Komposisi:</label>
                    <textarea name="komposisi" required><?= htmlspecialchars($row['KOMPOSISI']) ?></textarea>
                </div>
                <div class="form-group">
                    <label>Indikasi:</label>
                    <textarea name="indikasi" required><?= htmlspecialchars($row['INDIKASI']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Masa Berlaku:</label>
                    <input type="date" name="masa_berlaku" value="<?= htmlspecialchars(date('Y-m-d', strtotime($row['MASA BERLAKU']))) ?>" required>
                    <small>(Sebelumnya: <?= formatDate($row['MASA BERLAKU']) ?>)</small>
                </div>
            </div>
            <button type="submit">Update</button>
        </form>
        <div class="back-link">
            <a href="DataObat.php">Kembali</a>
        </div>
    </div>
</body>
</html>
