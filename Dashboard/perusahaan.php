<?php
session_start();
include '../koneksi.php';
$result = $conn->query("SELECT * FROM perusahaan");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="../Data/bpkil.png" type="image/x-icon">
  <title>Data Perusahaan</title>

  <!-- Custom fonts -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,800,900" rel="stylesheet" />
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />

  <!-- DataTables CSS -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />

</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
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
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Addons</div>

        <!-- Nav Item - Charts -->
        <li class="nav-item  active">
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
    <!-- End of Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i class="fa fa-bars"></i></button>
          <p class="d-none d-sm-inline-block ml-md-3 my-2">Tab Tambahan Data</p>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                <span class="mr-2 d-lg-inline text-gray-600 small">
                  <?= isset($_SESSION['Email']) ? htmlspecialchars($_SESSION['Email']) : 'Guest' ?>
                </span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" />
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="../login.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout</a>
              </div>
            </li>
          </ul>
        </nav>

        <div class="container-fluid">
          <p class="mb-4">
            <a href="add.php" class="btn btn-primary">Tambah Perusahaan</a>
          </p>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Database Perusahaan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Provinsi</th>
                      <th>Nama Perusahaan</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                      <tr>
                        <td><?= htmlspecialchars($row['PROVINSI']) ?></td>
                        <td><?= htmlspecialchars($row['NAMA PERUSAHAAN']) ?></td>
                        <td><?= htmlspecialchars($row['ALAMAT']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-success">Edit</a>
                            <hr>
                            <a href="hapus.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>

      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">&copy; Your Website 2024</div>
        </div>
      </footer>
    </div>
  </div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>

  <!-- DataTables JavaScript -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Initialize DataTables -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable({
        "pagingType": "full_numbers", // Show full pagination
        "pageLength": 10, // Show 10 entries by default
        "lengthMenu": [10, 25, 50, 100], // Options for number of entries
        "order": [], // Sort by the first column (Provinsi)
        "columnDefs": [
          {
            "targets": [3], // Disable sorting on the Action column
            "orderable": false
          }
        ]
      });
    });
  </script>

</body>

</html>
