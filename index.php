<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="Data/bpkil.png" type="image/x-icon">
  <title>BPKIL | Pencarian Ikan </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }

  .card-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 50px;
    max-width: 1200px;
    width: 100%;
    padding: 0 20px;
  }

  .card {
    width: 23rem;
    height: 15rem;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
    transition: transform 0.3s ease;
  }

  .card:hover {
    transform: translateY(-10px);
  }

  .card-body {
    padding: 30px;
  }

  .card-body i {
    font-size: 80px;
    color: #00796b;
    margin-bottom: 20px;
  }

  .card-body h5 {
    font-size: 20px;
    font-weight: bold;
    color: #00796b;
  }

  .section-title {
    color: #1e2a3a;
    font-size: 36px;
    font-weight: bold;
    margin-bottom: 30px;
    text-align: center;
  }

  .tooltip-container {
    position: relative;
    display: inline-block;
  }

  .tooltip-container .tooltip-text {
      visibility: hidden;
      width: 200px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      padding: 5px 10px;
      position: absolute;
      z-index: 1;
      bottom: 95%; /* Sesuaikan dengan posisi tooltip */
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
  }

  .tooltip-container:hover .tooltip-text {
      visibility: visible;
      opacity: 6;
  }

  /* Media Queries for Responsiveness */
  @media (max-width: 768px) {
    .card-container {
      gap: 20px;
    }

    .card {
      width: 100%;
      height: auto;
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 28px;
      margin-bottom: 20px;
    }

    .card-body i {
      font-size: 60px;
    }

    .card-body h5 {
      font-size: 18px;
    }
  }

  @media (max-width: 480px) {
    .section-title {
      font-size: 24px;
      margin-bottom: 15px;
    }

    .card-body i {
      font-size: 50px;
    }

    .card-body h5 {
      font-size: 16px;
    }
  }
</style>

</head>
<body>

  <h2 class="section-title">BPKIL | Smarth Pencarian</h2>

  <div class="card-container">
    <!-- Card 1 -->
    <a href="cekobat.php" target="_blank" style="text-decoration: none; color: inherit;" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik untuk melihat informasi merk dan registrasi obat ikan.">
    <div class="card">
        <div class="card-body">
            <i class="bi bi-clipboard2-fill"></i>
            <h5 class="card-title">Merk dan Registrasi</h5>
        </div>
    </div>
    </a>


    <!-- Card 2 -->
    <a href="ceknamaobat.php" target="_blank" style="text-decoration: none; color: inherit;" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik untuk melihat informasi komposisi, indikasi, nama perusahaan, golongan, bentuk dan jenis sediaan obat, sisa waktu serta status sertifikasi.">
    <div class="card">
      <div class="card-body">
        <i class="bi bi-clipboard2-heart-fill"></i>
        <h5 class="card-title">Tanya Obat Ikan</h5>
      </div>
    </div>
    </a>

    <!-- Card 3 -->
    <a href="cekobat.php" target="_blank" style="text-decoration: none; color: inherit;" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik untuk melihat informasi detail perusahaan obat ikan.">
    <div class="card">
      <div class="card-body">
        <i class="bi bi-clipboard2-heart"></i>
        <h5 class="card-title">Daftar Perusahaan</h5>
      </div>
    </div>
    </a>
  </div>

  <!-- Bootstrap 5 & Icons -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script>    
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover focus', // Tooltip aktif pada hover dan focus
                });
            });
        });
  </script>

</body>
</html>
