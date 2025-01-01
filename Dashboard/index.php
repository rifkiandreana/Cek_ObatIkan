<?php
  session_start();
  include '../koneksi.php';
  $result = $conn->query("SELECT * FROM obat_ikan");


  // Query untuk menghitung total obat
  $sql = "SELECT COUNT(*) AS total FROM obat_ikan"; 
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $totalObat = $row['total'];

  // Query untuk provinsi dengan jumlah obat terbanyak
  $query = "SELECT PROVINSI, COUNT(*) AS jumlah_obat FROM obat_ikan GROUP BY PROVINSI ORDER BY jumlah_obat DESC LIMIT 1";
  $result = mysqli_query($conn, $query);
  $topProvinsi = mysqli_fetch_assoc($result);

  // Pastikan variabel selalu didefinisikan
  $provinsi = $topProvinsi['PROVINSI'] ?? 'Tidak Ada Data';
  $jumlahObat = $topProvinsi['jumlah_obat'] ?? 0;

  // Ambil data untuk grafik
  $queryGrafik = "SELECT PROVINSI, COUNT(*) AS jumlah_obat FROM obat_ikan GROUP BY PROVINSI ORDER BY jumlah_obat DESC LIMIT 33";
  $resultGrafik = mysqli_query($conn, $queryGrafik);

  // Siapkan array untuk data grafik
  $provinsiData = [];
  $jumlahObatData = [];

  while ($row = mysqli_fetch_assoc($resultGrafik)) {
      $provinsiData[] = $row['PROVINSI'];
      $jumlahObatData[] = $row['jumlah_obat'];
  }

  while ($row = mysqli_fetch_assoc($result)) {
      $provinsiData[] = $row['PROVINSI'];
      $jumlahObatData[] = $row['jumlah_obat'];
  }


  // Query untuk menghitung jumlah status "Berlaku" dan "Tidak Berlaku"
  $queryStatus = "SELECT `STATUS SERTIFIKAT`, COUNT(*) AS jumlah FROM obat_ikan GROUP BY `STATUS SERTIFIKAT`";
  $resultStatus = mysqli_query($conn, $queryStatus);

  // Siapkan array untuk data pie chart
  $statusData = [];
  while ($row = mysqli_fetch_assoc($resultStatus)) {
      $statusData[$row['STATUS SERTIFIKAT']] = $row['jumlah'];
  }

  // Jika data untuk "Berlaku" atau "Tidak Berlaku" kosong, set ke 0
  $berlakuCount = $statusData['Berlaku'] ?? 0;
  $tidakBerlakuCount = $statusData['Kadaluarsa'] ?? 0;

  // Query untuk jumlah nama perusahaan unik per provinsi
  $queryGrafik = "
      SELECT 
          PROVINSI, 
          COUNT(DISTINCT `NAMA PERUSAHAAN`) AS jumlah_perusahaan 
      FROM 
          obat_ikan 
      GROUP BY 
          PROVINSI 
      ORDER BY 
          jumlah_perusahaan DESC
      LIMIT 33";
      
  $resultGrafik = mysqli_query($conn, $queryGrafik);

  // Pastikan query berhasil dijalankan
  if (!$resultGrafik) {
      die("Error dalam query: " . mysqli_error($conn));
  }

  // Siapkan array untuk data grafik
  $provinsiData = [];
  $jumlahPerusahaanData = [];

  while ($row = mysqli_fetch_assoc($resultGrafik)) {
      $provinsiData[] = $row['PROVINSI'];
      $jumlahPerusahaanData[] = $row['jumlah_perusahaan'];
  }

  // Query untuk menghitung jumlah status ASAL OBAT
  $queryasal = "SELECT `ASAL OBAT`, COUNT(*) AS asal FROM obat_ikan GROUP BY `ASAL OBAT`";
  $resultasal = mysqli_query($conn, $queryasal);

  // Siapkan array untuk data pie chart
  $asalData = [];
  while ($row = mysqli_fetch_assoc($resultasal)) {
      $asalData[$row['ASAL OBAT']] = $row['asal'];
  }

  // Jika data untuk "Berlaku" atau "Tidak Berlaku" kosong, set ke 0
  $asalCount = $asalData['Dalam Negeri'] ?? 0;
  $tidakasalCount = $asalData['Impor'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="../Data/bpkil.png" type="image/x-icon">
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-fish"></i>
          </div>
          
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Addons</div>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="perusahaan.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Perusahaan</span></a
          >
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
          <a class="nav-link" href="tables.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Obat</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>

  

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>

              <!-- Nav Item - Alerts -->

              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= isset($_SESSION['Email']) ? htmlspecialchars($_SESSION['Email']) : 'Guest' ?>
                </span>
                  <img class="img-profile rounded-circle" src="img/undraw_profile.svg" />
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="../login.php" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
  

            <!-- Content Row -->
            <div class="row">
              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Obat Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?= htmlspecialchars($totalObat) ?> <!-- Menampilkan total -->
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Jumlah Perusahaan -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Perusahaan Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php
                            // Query untuk menghitung jumlah perusahaan unik
                            $sql = "SELECT COUNT(DISTINCT `NAMA PERUSAHAAN`) AS total_perusahaan FROM obat_ikan"; // Ganti 'obat_ikan' dengan nama tabel Anda
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $totalPerusahaan = $row['total_perusahaan'];

                            // Tampilkan hasil
                            echo htmlspecialchars($totalPerusahaan);
                          ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pending Requests Card Example -->
              <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Provinsi Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          <?php
                              // Query untuk menghitung jumlah perusahaan unik
                              $sql = "SELECT COUNT(DISTINCT `PROVINSI`) AS total_provinsi FROM obat_ikan"; // Ganti 'obat_ikan' dengan nama tabel Anda
                              $result = mysqli_query($conn, $sql);
                              $row = mysqli_fetch_assoc($result);
                              $totalProvinsi = $row['total_provinsi'];

                              // Tampilkan hasil
                              echo htmlspecialchars($totalProvinsi);
                            ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Content Row -->

            <div class="row">
              <!-- Area Chart -->
              <div class="col-xl-6 col-lg-9">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Produksi Obat Per-provinsi</h6>
                    <div class="dropdown no-arrow">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                      </a>
                    </div>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                      <div class="chart-area">
                          <canvas id="obatChart"></canvas>
                      </div>
                  </div>
                </div>
              </div>

              <!-- Pie Chart -->
              <div class="col-xl-6 col-lg-5">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Tidak Berlaku dan berlaku</h6>
        
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                      <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                      <br>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Chart Obat Pertahun-->
              <div class="col-xl-6 col-lg-5">
                  <div class="card shadow mb-4">
                      <!-- Card Header - Dropdown -->
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Jumlah Perusahaan Terdaftar Berdasarkan Provinsi</h6>
                      </div>
                      <!-- Card Body -->
                      <div class="card-body">
                          <div class="chart-area pt-4 pb-2">
                              <canvas id="ProvinsiChart"></canvas>
                          </div>
                          <div class="mt-4 text-center small">
                              <br>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- Pie Chart -->
              <div class="col-xl-6 col-lg-5">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Asal Obat</h6>
                  </div>
                  <!-- Card Body -->
                  <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                      <canvas id="asalChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                      <br>
                      <br>
                    </div>
                  </div>
                </div>
              </div>
                 
            </div>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; BPKIL 2024</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="../login.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
  
    <script>
        //Untuk Jumlah Obat per provinsi
        var ctx = document.getElementById('obatChart').getContext('2d');
        var obatChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($provinsiData); ?>,  // Nama Provinsi
                datasets: [{
                    label: 'Jumlah Obat',
                    data: <?php echo json_encode($jumlahObatData); ?>, // Jumlah Obat
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',  // Warna batang
                    borderColor: 'rgba(54, 162, 235, 1)',  // Warna garis tepi batang
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Untuk Pie chart status sertifikasi
        var berlakuCount = <?php echo $berlakuCount; ?>;
        var tidakBerlakuCount = <?php echo $tidakBerlakuCount; ?>;

        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: ['Berlaku', 'Kadaluarsa'],
            datasets: [{
              data: [berlakuCount, tidakBerlakuCount],
              backgroundColor: ['#4e73df', '#1cc88a'], // Warna untuk 'Berlaku' dan 'Tidak Berlaku'
              hoverBackgroundColor: ['#2e59d9', '#17a673'],
              hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              tooltip: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.label + ': ' + tooltipItem.raw;
                  }
                }
              }
            }
          }
        });

        //Untuk nama perusahaan perprovinsi
        var ctx = document.getElementById('ProvinsiChart').getContext('2d');
        var perusahaanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($provinsiData); ?>,  // Nama Provinsi
                datasets: [{
                    label: 'Jumlah Perusahaan',
                    data: <?php echo json_encode($jumlahPerusahaanData); ?>,  // Jumlah Perusahaan Unik
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',  // Warna batang
                    borderColor: 'rgba(75, 192, 192, 1)',  // Warna garis tepi batang
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Untuk Pie chart asal obat
        var asalCount = <?php echo $asalCount; ?>;
        var tidakasalCount = <?php echo $tidakasalCount; ?>;

        var ctx = document.getElementById('asalChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: ['Dalam Negeri', 'Impor'],
            datasets: [{
              data: [asalCount, tidakasalCount],
              backgroundColor: ['#e82b91', '#1cc88a'], // Warna untuk 'Berlaku' dan 'Tidak Berlaku'
              hoverBackgroundColor: ['#ff1493', '#17a673'],
              hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              tooltip: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.label + ': ' + tooltipItem.raw;
                  }
                }
              }
            }
          }
        });

        
        
    </script>
  </body>
</html>
