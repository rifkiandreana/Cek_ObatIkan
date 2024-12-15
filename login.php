<?php
session_start();
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['Email'];
    $password = md5($_POST['password']); // Hash password dengan MD5

    $sql = "SELECT * FROM admin WHERE Email='$Email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['Email'] = $row['Email'];
        header("Location: Dashboard/index.php"); // Redirect to the appropriate home page
    } else {
        echo "Login failed. Please check your credentials.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .login-container .form-group {
            margin-bottom: 15px;
        }
        .login-container .form-control {
            border-radius: 4px;
        }
        .login-container .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .login-container .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .login-container .text-center {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Login Admin</h2>
        <form action="" method="post" >
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="text" name="Email" class="form-control" id="Email" placeholder="Enter your Email" >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" >
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="text-center">
                <!-- <a href="#">Lupa sandi?</a> -->
                <!-- <p>Belum punya akun? <a href="signup.php">Daftar disini</a></p> -->
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>