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

    
    if (isset($_GET['download_pdf'])) {
        // Ambil parameter `order_by` untuk menentukan urutan
        $orderBy = $_GET['order_by'] ?? '';
    
        // Urutkan data berdasarkan pilihan user untuk PDF
        if ($orderBy === 'nama_obat') {
            usort($results, fn($a, $b) => strcmp($a['NAMA OBAT'], $b['NAMA OBAT']));
        } elseif ($orderBy === 'sisa_waktu') {
            usort($results, fn($a, $b) => (int)$b['SISA WAKTU'] - (int)$a['SISA WAKTU']);
        }
        
        // Generate PDF setelah data diurutkan
        generatePDF($results);
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
            $komposisi = $row['KOMPOSISI'];
            $pdf->MultiCell(0, 6, $komposisi, 0, 1);
    
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
    
    
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Data/bpkil.png" type="image/x-icon">
    <title>Hasil Merk dan Registrasi</title>
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
        .footer {
        margin-top: 20px; /* Mengurangi jarak antara footer dan tabel */
        text-align: center;
        color: #555;
        font-size: 14px;
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


        function sortTableByColumn(columnIndex, order) {
            const table = document.getElementById("dataTable");
            const rows = Array.from(table.querySelectorAll("tbody tr"));
            const sortedRows = rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[columnIndex].textContent.trim();
                const cellB = rowB.cells[columnIndex].textContent.trim();
                
                // Mengonversi cellA dan cellB menjadi angka jika kolomnya adalah 'sisa_waktu'
                const valueA = columnIndex === 1 ? parseInt(cellA) : cellA; // Misalkan kolom 'sisa_waktu' ada di indeks 1
                const valueB = columnIndex === 1 ? parseInt(cellB) : cellB;
                
                return order === "asc" 
                    ? valueA > valueB ? 1 : -1
                    : valueA < valueB ? 1 : -1;
            });
            sortedRows.forEach(row => table.querySelector("tbody").appendChild(row));
        }



        function updateOrderBy(value) {
            const orderBy = document.getElementById('order-by');
            const currentOrder = orderBy.value;
            const columnIndex = value === "nama_obat" ? 0 : 1;
            const order = currentOrder === value ? "desc" : "asc";
            orderBy.value = value;

            // Urutkan tabel berdasarkan kolom yang dipilih
            sortTableByColumn(columnIndex, order);

            // Update URL untuk menyertakan parameter order_by
            const url = new URL(window.location.href);
            url.searchParams.set('order_by', value); // Menambahkan atau mengubah parameter 'order_by'
            window.history.pushState({}, '', url); // Memperbarui URL tanpa memuat ulang halaman

           
        }



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
            <a href="cekobat.php">Kembali</a>
        </button>



        <form id="download-form" action="" method="get">
            <input type="hidden" name="main_keyword" value="<?= htmlspecialchars($main_keyword); ?>">
            <input type="hidden" name="order_by" id="order-by" value="<?= isset($_GET['order_by']) ? htmlspecialchars($_GET['order_by']) : ''; ?>">
            
            <select class="filter-select" onchange="updateOrderBy(this.value)">
                <option value="">Urutkan</option>
                <option value="nama_obat" <?= isset($_GET['order_by']) && $_GET['order_by'] === 'nama_obat' ? 'selected' : ''; ?>>Nama Obat</option>
                <option value="sisa_waktu" <?= isset($_GET['order_by']) && $_GET['order_by'] === 'sisa_waktu' ? 'selected' : ''; ?>>Sisa Waktu</option>
            </select>
            
            <button type="submit" name="download_pdf" class="btn-download">Unduh Hasil Pencarian</button>
        </form>
        


      

        <!-- <select class="filter-select" onchange="this.value === 'nama_obat' ? sortTable(0) : sortTable(13, false, true);">
            <option value="">Urutkan</option>
            <option value="nama_obat">Nama Obat</option>
            <option value="sisa_waktu">Sisa Waktu</option>
        </select> -->

        <div class="table-container">
            <table id="dataTable">
                <thead>
                    <tr>
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
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
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
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>&copy; 2024 Semua Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>


