<?php
// Konfigurasi koneksi ke database
$host = 'localhost';
$dbname = 'cek_obat_ikan';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil input pencarian dari form
    $main_keyword = isset($_GET['main_keyword']) ? $_GET['main_keyword'] : '';
    $nama_perusahaan = isset($_GET['nama_perusahaan']) ? $_GET['nama_perusahaan'] : '';
    $alamat = isset($_GET['alamat']) ? $_GET['alamat'] : '';
    $provinsi = isset($_GET['provinsi']) ? $_GET['provinsi'] : '';
    $jenis_perusahaan = isset($_GET['jenis_perusahaan']) ? $_GET['jenis_perusahaan'] : '';
    $asal_obat = isset($_GET['asal_obat']) ? $_GET['asal_obat'] : '';
    $golongan_obat = isset($_GET['golongan_obat']) ? $_GET['golongan_obat'] : '';
    $bentuk_sediaan = isset($_GET['bentuk_sediaan']) ? $_GET['bentuk_sediaan'] : '';
    $jenis_sediaan = isset($_GET['jenis_sediaan']) ? $_GET['jenis_sediaan'] : '';
    $komposisi = isset($_GET['komposisi']) ? $_GET['komposisi'] : '';
    $indikasi = isset($_GET['indikasi']) ? $_GET['indikasi'] : '';
    $status_sertifikat = isset($_GET['status_sertifikat']) ? $_GET['status_sertifikat'] : '';

    // Bangun query dengan kondisi dinamis
    $query = "SELECT * FROM obat_ikan WHERE 1=1";
$params = [];

if ($main_keyword) {
    $query .= " AND (`NAMA OBAT` LIKE :main_keyword OR `NOMOR PENDAFTARAN` LIKE :main_keyword)";
    $params[':main_keyword'] = "%$main_keyword%";
}
if ($nama_perusahaan) {
    $query .= " AND `NAMA PERUSAHAAN` LIKE :nama_perusahaan";
    $params[':nama_perusahaan'] = "%$nama_perusahaan%";
}
if ($alamat) {
    $query .= " AND `ALAMAT` LIKE :alamat";
    $params[':alamat'] = "%$alamat%";
}
if ($provinsi) {
    $query .= " AND `PROVINSI` LIKE :provinsi";
    $params[':provinsi'] = "%$provinsi%";
}
if ($jenis_perusahaan) {
    $query .= " AND `JENIS PERUSAHAAN` LIKE :jenis_perusahaan";
    $params[':jenis_perusahaan'] = "%$jenis_perusahaan%";
}
if ($asal_obat) {
    $query .= " AND `ASAL OBAT` LIKE :asal_obat";
    $params[':asal_obat'] = "%$asal_obat%";
}
if ($golongan_obat) {
    $query .= " AND `GOLONGAN OBAT` LIKE :golongan_obat";
    $params[':golongan_obat'] = "%$golongan_obat%";
}
if ($bentuk_sediaan) {
    $query .= " AND `BENTUK SEDIAAN` LIKE :bentuk_sediaan";
    $params[':bentuk_sediaan'] = "%$bentuk_sediaan%";
}
if ($jenis_sediaan) {
    $query .= " AND `JENIS SEDIAAN` LIKE :jenis_sediaan";
    $params[':jenis_sediaan'] = "%$jenis_sediaan%";
}
if ($komposisi) {
    $query .= " AND `KOMPOSISI` LIKE :komposisi";
    $params[':komposisi'] = "%$komposisi%";
}
if ($indikasi) {
    $query .= " AND `INDIKASI` LIKE :indikasi";
    $params[':indikasi'] = "%$indikasi%";
}
if ($status_sertifikat) {
    $query .= " AND `STATUS SERTIFIKAT` LIKE :status_sertifikat";
    $params[':status_sertifikat'] = "%$status_sertifikat%";
}

    // Eksekusi query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Koneksi atau query bermasalah: " . $e->getMessage();
        die();
    }

//vendor/setasign/fpdf/fpdf.php
    // Fungsi untuk membuat PDF
    function generatePDF($results) {
        require('vendor/setasign/fpdf/fpdf.php');
    
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
    
        // Judul
           // Menambahkan logo di samping kiri judul
    $logoPath = 'Data/bpkil.png'; // Pastikan file logo berada di lokasi ini
    $pdf->Image($logoPath, 10, 10, 20); // Atur posisi (x, y) dan lebar logo (20 mm)
    
    // Judul di sebelah kanan logo
    $pdf->SetXY(35, 10); // Pindahkan posisi tulisan ke kanan setelah logo
    $pdf->Cell(0, 10, 'Hasil Pencarian Obat Ikan', 0, 1, 'L'); // Posisi kiri untuk judul
    
    // Tanggal pencarian di bawah judul
    $pdf->SetXY(35, 20); // Posisikan tanggal di bawah judul
    $tanggalPencarian = date('d-m-Y');
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(0, 10, "Tanggal Pencarian: $tanggalPencarian", 0, 1, 'L');
    $pdf->Ln(5);
    
        $pdf->SetFont('Arial', '', 8);
        $no = 1;
    

        // Tampilkan setiap data sebagai blok
        foreach ($results as $row) {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(0, 6, "Data Obat #$no", 0, 1);
            $pdf->SetFont('Arial', '', 8);
    
            $pdf->Cell(50, 6, 'Nama Obat:', 0, 0);
            $pdf->Cell(0, 6, $row['NAMA OBAT'], 0, 1);
    
            $pdf->Cell(50, 6, 'Nama Perusahaan:', 0, 0);
            $pdf->Cell(0, 6, $row['NAMA PERUSAHAAN'], 0, 1);
    
            // Mengatur teks alamat dengan MultiCell untuk menjaga keselarasan
            $pdf->Cell(50, 6, 'Alamat:', 0, 0);
            $alamat = $row['ALAMAT'];
            $pdf->MultiCell(0, 6, $alamat, 0); // Menggunakan MultiCell untuk alamat
    
            $pdf->Cell(50, 6, 'Provinsi:', 0, 0);
            $pdf->Cell(0, 6, $row['PROVINSI'], 0, 1);
    
            $pdf->Cell(50, 6, 'Jenis Perusahaan:', 0, 0);
            $pdf->Cell(0, 6, $row['JENIS PERUSAHAAN'], 0, 1);
    
            $pdf->Cell(50, 6, 'Nomor Pendaftaran:', 0, 0);
            $pdf->Cell(0, 6, $row['NOMOR PENDAFTARAN'], 0, 1);
    
            $pdf->Cell(50, 6, 'Asal Obat:', 0, 0);
            $pdf->Cell(0, 6, $row['ASAL OBAT'], 0, 1);
    
            $pdf->Cell(50, 6, 'Golongan Obat:', 0, 0);
            $pdf->Cell(0, 6, $row['GOLONGAN OBAT'], 0, 1);
    
            $pdf->Cell(50, 6, 'Bentuk Sediaan:', 0, 0);
            $pdf->Cell(0, 6, $row['BENTUK SEDIAAN'], 0, 1);
    
            $pdf->Cell(50, 6, 'Jenis Sediaan:', 0, 0);
            $pdf->Cell(0, 6, $row['JENIS SEDIAAN'], 0, 1);
    
            $pdf->Cell(50, 6, 'Komposisi:', 0, 0);
            $pdf->Cell(0, 6, $row['KOMPOSISI'], 0, 1);
    
            $pdf->Cell(50, 6, 'Indikasi:', 0, 0);
            $indikasi = $row['INDIKASI'];
            $pdf->MultiCell(0, 6, $indikasi, 0); // Menggunakan MultiCell untuk alamat
    
            $pdf->Cell(50, 6, 'Masa Berlaku:', 0, 0);
            $pdf->Cell(0, 6, $row['MASA BERLAKU'], 0, 1);
    
            $pdf->Cell(50, 6, 'Sisa Waktu:', 0, 0);
            $pdf->Cell(0, 6, $row['SISA WAKTU'], 0, 1);
    
            $pdf->Cell(50, 6, 'Status Sertifikat:', 0, 0);
            $pdf->Cell(0, 6, $row['STATUS SERTIFIKAT'], 0, 1);
    
            // Spasi antar blok data
            $pdf->Ln(8);
            $no++;
        }
    
        // Format tanggal saat ini
        $tanggal = date('Y-m-d');
        // Output PDF dengan nama file yang berisi tanggal
        $pdf->Output('D', "BPKIL_ObatIkan_$tanggal.pdf");
    }
    
    
    

    // Cek jika ada permintaan untuk mengunduh PDF
    if (isset($_GET['download_pdf'])) {
        generatePDF($results);
        exit; // Hentikan eksekusi setelah PDF dihasilkan
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian Obat Ikan</title>
    <style>
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
        }
        .container {
            width:auto;
            margin-left: 20px;
            margin-right: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #00796b;
            color: #fff;
            border-radius: 6px;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
        .time {
            font-size: 14px;
            font-weight: bold;
        }
        table {
            width: auto;
            border-collapse: collapse;
            background-color: #ffffff;
            margin-top: 20px;
           
           /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0); */
        }        th, td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        th {
            background-color: #009688;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .nomor {
            width: 5%;
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #555;
            font-size: 14px;
        }
        .btn-download {
            display: inline-block;
            padding: 10px 10px;
            background-color: #00796b;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn-download:hover {
            background-color: #004d40;
        }

        .btn-kembali {
            display: inline-block;
            background-color: red;
            color: white;
            padding: 10px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
        }
        .btn-kembali a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-kembali:hover {
            background-color: darkred;
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
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="Data/bpkil.png" alt="Logo Obat Ikan">
            </div>
            <div class="time" id="time"></div>
        </div>

        <h1 style="text-align: center;">Hasil Pencarian Obat Ikan</h1>

        <button type="submit" class="btn-kembali">
             <a href="index.php">Kembali</a>
        </button>

        <form action="" method="get">
            <input type="hidden" name="main_keyword" value="<?= htmlspecialchars($main_keyword); ?>">
            <!-- Add other hidden inputs for search criteria as before -->
            <input type="hidden" name="main_keyword" value="<?= htmlspecialchars($main_keyword); ?>">
            <input type="hidden" name="nama_perusahaan" value="<?= htmlspecialchars($nama_perusahaan); ?>">
            <input type="hidden" name="alamat" value="<?= htmlspecialchars($alamat); ?>">
            <input type="hidden" name="provinsi" value="<?= htmlspecialchars($provinsi); ?>">
            <input type="hidden" name="jenis_perusahaan" value="<?= htmlspecialchars($jenis_perusahaan); ?>">
            <input type="hidden" name="asal_obat" value="<?= htmlspecialchars($asal_obat); ?>">
            <input type="hidden" name="golongan_obat" value="<?= htmlspecialchars($golongan_obat); ?>">
            <input type="hidden" name="bentuk_sediaan" value="<?= htmlspecialchars($bentuk_sediaan); ?>">
            <input type="hidden" name="jenis_sediaan" value="<?= htmlspecialchars($jenis_sediaan); ?>">
            <input type="hidden" name="komposisi" value="<?= htmlspecialchars($komposisi); ?>">
            <input type="hidden" name="indikasi" value="<?= htmlspecialchars($indikasi); ?>">
            <input type="hidden" name="status_sertifikat" value="<?= htmlspecialchars($status_sertifikat); ?>">
            <button type="submit" name="download_pdf" class="btn-download">Unduh Hasil Pencararian</button>

        </form>
      
       
        

        <?php if (count($results) > 0): ?>
            <table>
                <tr>
                    <th class="nomor">NO</th>
                    <th>NAMA OBAT</th>
                    <th>NAMA PERUSAHAAN</th>
                    <th>ALAMAT</th>
                    <th>PROVINSI</th>
                    <th>JENIS PERUSAHAAN</th>
                    <th>NOMOR PENDAFTARAN</th>
                    <th>ASAL OBAT</th>
                    <th>GOLONGAN OBAT</th>
                    <th>BENTUK SEDIAAN</th>
                    <th>JENIS SEDIAAN</th>
                    <th>KOMPOSISI</th>
                    <th>INDIKASI</th>
                    <th>MASA BERLAKU</th>
                    <th>SISA WAKTU</th>
                    <th>STATUS SERTIFIKAT</th>
                </tr>
                <?php $no = 1; ?>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td class="nomor"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['NAMA OBAT']); ?></td>
                        <td><?= htmlspecialchars($row['NAMA PERUSAHAAN']); ?></td>
                        <td><?= htmlspecialchars($row['ALAMAT']); ?></td>
                        <td><?= htmlspecialchars($row['PROVINSI']); ?></td>
                        <td><?= htmlspecialchars($row['JENIS PERUSAHAAN']); ?></td>
                        <td><?= htmlspecialchars($row['NOMOR PENDAFTARAN']); ?></td>
                        <td><?= htmlspecialchars($row['ASAL OBAT']); ?></td>
                        <td><?= htmlspecialchars($row['GOLONGAN OBAT']); ?></td>
                        <td><?= htmlspecialchars($row['BENTUK SEDIAAN']); ?></td>
                        <td><?= htmlspecialchars($row['JENIS SEDIAAN']); ?></td>
                        <td><?= htmlspecialchars($row['KOMPOSISI']); ?></td>
                        <td><?= htmlspecialchars($row['INDIKASI']); ?></td>
                        <td><?= htmlspecialchars($row['MASA BERLAKU']); ?></td>
                        <td><?= htmlspecialchars($row['SISA WAKTU']); ?></td>
                        <td><?= htmlspecialchars($row['STATUS SERTIFIKAT']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Data tidak ditemukan.</p>
        <?php endif; ?>

        <div class="footer">
            <p>&copy; 2024 Semua Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>
