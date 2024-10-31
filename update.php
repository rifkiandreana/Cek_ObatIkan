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
</head>
<body>
    <h2>Edit Obat Ikan</h2>
    <form method="post">
        <label>Nama Obat:</label>
        <input type="text" name="nama_obat" value="<?= htmlspecialchars($row['NAMA OBAT']) ?>" required><br>
        
        <label>Nama Perusahaan:</label>
        <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($row['NAMA PERUSAHAAN']) ?>" required><br>
        
        <label>Alamat:</label>
        <input type="text" name="alamat" value="<?= htmlspecialchars($row['ALAMAT']) ?>" required><br>
        
        <label>Provinsi:</label>
        <input type="text" name="provinsi" value="<?= htmlspecialchars($row['PROVINSI']) ?>" required><br>
        
        <label>Jenis Perusahaan:</label>
        <input type="text" name="jenis_perusahaan" value="<?= htmlspecialchars($row['JENIS PERUSAHAAN']) ?>" required><br>
        
        <label>Nomor Pendaftaran:</label>
        <input type="text" name="nomor_pendaftaran" value="<?= htmlspecialchars($row['NOMOR PENDAFTARAN']) ?>" required><br>
        
        <label>Asal Obat:</label>
        <input type="text" name="asal_obat" value="<?= htmlspecialchars($row['ASAL OBAT']) ?>" required><br>
        
        <label>Golongan Obat:</label>
        <input type="text" name="golongan_obat" value="<?= htmlspecialchars($row['GOLONGAN OBAT']) ?>" required><br>
        
        <label>Bentuk Sediaan:</label>
        <input type="text" name="bentuk_sediaan" value="<?= htmlspecialchars($row['BENTUK SEDIAAN']) ?>" required><br>
        
        <label>Jenis Sediaan:</label>
        <input type="text" name="jenis_sediaan" value="<?= htmlspecialchars($row['JENIS SEDIAAN']) ?>" required><br>
        
        <label>Komposisi:</label>
        <input type="text" name="komposisi" value="<?= htmlspecialchars($row['KOMPOSISI']) ?>" required><br>
        
        <label>Indikasi:</label>
        <input type="text" name="indikasi" value="<?= htmlspecialchars($row['INDIKASI']) ?>" required><br>
        
        <label>Masa Berlaku:</label>
        <input type="date" name="masa_berlaku" value="<?= htmlspecialchars(date('Y-m-d', strtotime($row['MASA BERLAKU']))) ?>" required><br>
        <small>(Sebelumnya: <?= formatDate($row['MASA BERLAKU']) ?>)</small><br>

        
        
        <button type="submit">Update</button>
    </form>
    <a href="index.php">Kembali</a>
</body>
</html>
