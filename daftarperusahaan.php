<?php
// Konfigurasi koneksi ke database
$host = 'localhost';
$dbname = 'cek_obat_ikan';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Variabel untuk pencarian
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Query data perusahaan dengan pencarian jika ada
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT * FROM perusahaan WHERE `PROVINSI` LIKE :search OR `NAMA PERUSAHAAN` LIKE :search OR `ALAMAT` LIKE :search");
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM perusahaan");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Menangani permintaan unduh PDF
    if (isset($_GET['download_pdf'])) {
        generatePDF($results);
        exit;
    }
} catch (PDOException $e) {
    echo "Koneksi atau query bermasalah: " . $e->getMessage();
    die();
}

// Fungsi generatePDF tetap di sini
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
    <title>Data Perusahaan Obat Ikan</title>
    <style>
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #00796b;
            color: white;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
        .container {
            margin: 20px auto;
            max-width: 90%;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color:rgb(0, 0, 0);
        }
        .search-form {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .search-form input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .time {
            font-size: 14px;
            font-weight: bold;
        }
        .search-form button {
            padding: 10px 15px;
            margin-left: 5px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #004d40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #009688;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
        .btn-download {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .btn-download:hover {
            background-color: #004d40;
        }
        .btn-kembali {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            position: absolute;
           
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
    <div class="header">
        <div class="logo">
            <img src="Data/bpkil.png" alt="Logo Perusahaan">
        </div>
        <div class="time" id="time"></div>
    </div>
    <div class="container">
        <h1>Daftar Perusahaan</h1>

        <!-- Form pencarian -->
        <button type="submit" class="btn-kembali">
             <a href="index.php">Kembali</a>
        </button>
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Cari perusahaan, provinsi, atau alamat..." value="<?= htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
        </form>

        <a href="?download_pdf=1&search=<?= urlencode($search) ?>" class="btn-download">Unduh Hasil Pencarian</a>

   
        <?php if (!empty($results)): ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Provinsi</th>
                        <th>Nama Perusahaan</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['PROVINSI']); ?></td>
                            <td><?= htmlspecialchars($row['NAMA PERUSAHAAN']); ?></td>
                            <td><?= htmlspecialchars($row['ALAMAT']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada data yang sesuai dengan pencarian.</p>
        <?php endif; ?>
    </div>
    <div class="footer">
        <p>&copy; 2024 BPKIL - Data Perusahaan Obat Ikan</p>
    </div>
</body>
</html>
