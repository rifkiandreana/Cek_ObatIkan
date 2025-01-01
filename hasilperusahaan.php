<?php
// Konfigurasi koneksi ke database
$host = 'localhost';
$dbname = 'cek_obat_ikan';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $main_keyword = isset($_GET['main_keyword']) ? $_GET['main_keyword'] : '';
    $provinsi = isset($_GET['provinsi']) ? $_GET['provinsi'] : '';
    $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';
    
    // Bangun query
    $query = "SELECT * FROM perusahaan WHERE 1=1";
    $params = [];
    
    if ($main_keyword) {
        $query .= " AND `NAMA PERUSAHAAN` LIKE :main_keyword";
        $params[':main_keyword'] = "%$main_keyword%";
    }
    
    if ($provinsi) {
        $query .= " AND `PROVINSI` LIKE :provinsi";
        $params[':provinsi'] = "%$provinsi%";
    }
    
    if ($order_by === 'nama_perusahaan') {
        $query .= " ORDER BY `NAMA PERUSAHAAN` ASC";
    } elseif ($order_by === 'alamat') {
        $query .= " ORDER BY `ALAMAT` ASC";
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (isset($_GET['download_pdf'])) {
        generatePDF($results);
        exit;
    
    }
} catch (PDOException $e) {
    echo "Koneksi atau query bermasalah: " . $e->getMessage();
    die();
}

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
    $pdf->Cell(0, 10, 'Hasil Pencarian Perusahaan', 0, 1, 'L'); // Posisi kiri untuk judul
    
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
        $pdf->Cell(0, 6, "Data Perusahaan #$no", 0, 1);
        $pdf->SetFont('Arial', '', 8);

        $pdf->Cell(50, 6, 'Nama Perusahaan:', 0, 0);
        $pdf->Cell(0, 6, $row['NAMA PERUSAHAAN'], 0, 1);

        $pdf->Cell(50, 6, 'Provinsi:', 0, 0);
        $pdf->Cell(0, 6, $row['PROVINSI'], 0, 1);

        // Mengatur teks alamat dengan MultiCell untuk menjaga keselarasan
        $pdf->Cell(50, 6, 'Alamat:', 0, 0);
        $alamat = $row['ALAMAT'];
        $pdf->MultiCell(0, 6, $alamat, 0); // Menggunakan MultiCell untuk alamat

        // Spasi antar blok data
        $pdf->Ln(8);
        $no++;
    }

    // Format tanggal saat ini
    $tanggal = date('Y-m-d');
    // Output PDF dengan nama file yang berisi tanggal
    $pdf->Output('D', "BPKIL_ObatIkan_$tanggal.pdf");
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Data/bpkil.png" type="image/x-icon">
    <title>Hasil Tanya Perusahaan</title>
    <style>
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
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
        .container {
            margin: 20px auto;
            max-width: 100%;
        }
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        th {
            background-color: #009688;
            color: #fff;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #555;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-download, .btn-kembali, .filter-select {
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-decoration: none;
        }
        .btn-download {
            background-color: #00796b;
            color: #fff;
        }
        .btn-download:hover {
            background-color: #004d40;
        }
        .btn-kembali {
            background-color: red;
            color: white;
        }
        .btn-kembali a {
            color: white;
            text-decoration: none;
        }
        .btn-kembali:hover {
            background-color: darkred;
        }
        .filter-select {
            background-color: #009688;
            color: #fff;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            th, td {
                font-size: 10px;
                padding: 5px;
            }
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
    <script>
        function showDateTime() {
            const timeElement = document.getElementById("time");
            const now = new Date();
            const tanggal = now.toLocaleDateString("id-ID", { day: '2-digit', month: 'long', year: 'numeric' });
            const waktu = now.toLocaleTimeString("id-ID", { hour: '2-digit', minute: '2-digit' });
            timeElement.textContent = `${tanggal} ${waktu}`;
        }
        setInterval(showDateTime, 1000);
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="Data/bpkil.png" alt="Logo Perusahaan">
            </div>
            <div class="time" id="time"></div>
        </div>
        <h1 style="text-align: center;">Hasil Pencarian Perusahaan</h1>
        <button type="submit" class="btn-kembali">
            <a href="cekperusahaan.php">Kembali</a>
        </button>
        <form id="download-form" action="" method="get">
            <input type="hidden" name="main_keyword" value="<?= htmlspecialchars($main_keyword); ?>">
            <input type="hidden" name="provinsi" value="<?= htmlspecialchars($provinsi); ?>">
            <input type="hidden" name="order_by" value="<?= htmlspecialchars($order_by); ?>">
            <button type="submit" name="download_pdf" class="btn-download">Unduh Hasil Pencarian</button>
        </form>

        <div class="table-container">
            <?php if (!empty($results)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Provinsi</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['PROVINSI']); ?></td>
                                <td><?= htmlspecialchars($row['NAMA PERUSAHAAN']); ?></td>
                                <td><?= htmlspecialchars($row['ALAMAT']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada data ditemukan.</p>
            <?php endif; ?>
        </div>
        <div class="footer">
            <p>&copy; 2024 BPKIL - Data Perusahaan</p>
        </div>
    </div>
</body>
</html>
