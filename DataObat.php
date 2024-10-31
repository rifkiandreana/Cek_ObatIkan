<?php
include 'koneksi.php';
$result = $conn->query("SELECT * FROM obat_ikan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat Ikan</title>
    <style>
        /* Gunakan box-sizing untuk perhitungan yang lebih baik */
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        a {
            text-decoration: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .add-button {
            background-color: #28a745;
            display: inline-block;
            margin-bottom: 20px;
        }
        table {
            width: 100%; /* Mengatur lebar tabel menjadi 100% */
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            overflow: hidden; /* Mencegah overflow */
        }
        th, td {
            padding: 8px; /* Menyesuaikan padding untuk lebih kompak */
            text-align: left;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word; /* Memungkinkan teks panjang dibungkus ke baris baru */
            max-width: 200px; /* Mengatur lebar maksimum untuk kolom */
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 100;
            display: none; /* Tersembunyi secara default */
        }
        .back-to-top a {
            background-color: #007bff;
            padding: 10px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }
    </style>
    <script>
        window.onscroll = function() {
            const button = document.getElementById("backToTop");
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        };

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</head>
<body>
    <h2>Data Obat Ikan</h2>
    <a href="create.php" class="add-button">Tambah Obat Ikan</a>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Nama Perusahaan</th>
            <th>Alamat</th>
            <th>Provinsi</th>
            <th>Jenis Perusahaan</th>
            <th>Nomor Pendaftaran</th>
            <th>Asal Obat</th>
            <th>Golongan Obat</th>
            <th>Bentuk Sediaan</th>
            <th>Jenis Sediaan</th>
            <th>Komposisi</th>
            <th>Indikasi</th>
            <th>Masa Berlaku</th>
            <th>Sisa Waktu</th>
            <th>Status Sertifikat</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['NO'] ?></td>
            <td><?= $row['NAMA OBAT'] ?></td>
            <td><?= $row['NAMA PERUSAHAAN'] ?></td>
            <td><?= $row['ALAMAT'] ?></td>
            <td><?= $row['PROVINSI'] ?></td>
            <td><?= $row['JENIS PERUSAHAAN'] ?></td>
            <td><?= $row['NOMOR PENDAFTARAN'] ?></td>
            <td><?= $row['ASAL OBAT'] ?></td>
            <td><?= $row['GOLONGAN OBAT'] ?></td>
            <td><?= $row['BENTUK SEDIAAN'] ?></td>
            <td><?= $row['JENIS SEDIAAN'] ?></td>
            <td><?= $row['KOMPOSISI'] ?></td>
            <td><?= $row['INDIKASI'] ?></td>
            <td><?= $row['MASA BERLAKU'] ?></td>
            <td><?= $row['SISA WAKTU'] ?></td>
            <td><?= $row['STATUS SERTIFIKAT'] ?></td>
            <td>
                <a href="update.php?no=<?= $row['NO'] ?>">Edit</a> | 
                <a href="delete.php?no=<?= $row['NO'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="back-to-top" id="backToTop">
        <a href="javascript:void(0);" onclick="scrollToTop()">Kembali ke Atas</a>
    </div>
</body>
</html>
