<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

// Ambil data perusahaan berdasarkan 'id'
$result = $conn->query("SELECT * FROM perusahaan WHERE id=$id");
$row = $result->fetch_assoc();

// Cek jika data perusahaan ditemukan
if (!$row) {
    die("Data perusahaan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat'];
    $provinsi = $_POST['provinsi'];

    // Query untuk update data perusahaan
    $sql = "UPDATE perusahaan SET 
            `NAMA PERUSAHAAN` = ?, 
            `ALAMAT` = ?, 
            `PROVINSI` = ? 
            WHERE `id` = ?";

    // Menyiapkan dan mengikat parameter untuk query update
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    $stmt->bind_param("sssi", $nama_perusahaan, $alamat, $provinsi, $id);

    if ($stmt->execute()) {
        header("Location: perusahaan.php"); // Redirect ke halaman tabel setelah update
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Perusahaan</title>
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
            margin-bottom: 20px;

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
            margin-top: 15px;
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
            <img src="../Data/bpkil.png" alt="Logo" class="logo">
            <div class="time">Waktu: <span id="current-time"></span></div>
        </div>
        <h2>Edit Data Perusahaan</h2>
        <form method="post">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Perusahaan:</label>
                    <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($row['NAMA PERUSAHAAN']) ?>" required>
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
                    <label>Alamat:</label>
                    <textarea name="alamat" required><?= htmlspecialchars($row['ALAMAT']) ?></textarea>
                </div>
            </div>
            <button type="submit">Update</button>
        </form>
        <div class="back-link">
            <a href="perusahaan.php">Kembali</a>
        </div>
    </div>
</body>
</html>
