<?php
require('config/koneksi.php');

session_start();

if(isset($_POST['submit'])){
    $username = $_POST['txt_username'];
    $pass = $_POST['txt_pass'];


    if(!empty(trim($username)) && !empty($pass)){

        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);
        $num = mysqli_num_rows($result);

        while($row = mysqli_fetch_array($result)){
            $userName = $row['username'];
			$passVal = $row['password'];
            $userVal = $row['nama_admin'];
            $level = $row['level'];
        }

        if($num != 0){
            if($userName == $username && $passVal == $pass){
				$_SESSION['username'] = $userName;
				$_SESSION['nama_admin'] = $userVal;	
				$_SESSION['level_admin'] = $level;
				header('Location: index.php');
            }else{
                $error = 'User atau password salah';
				echo "<script type='text/javascript'>alert('$error');</script>";
            }
        }else{
            $error = 'User tidak ditemukan!';
            echo "<script type='text/javascript'>alert('$error');</script>";
        }
    }else{
        $error = 'Isi username dan password terlebih dahulu!';
		echo "<script type='text/javascript'>alert('$error');</script>";
    }	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/mylogin.css">
</head>

<body class="my-login-page">
	<div></div>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper p-3">
					<div class="card fat">
						<div class="card-body">
							<img src="../img/logo-sekolah.png" class="card-img-top" alt="...">
							<h4 class="card-title">Login</h4>
							<form method="POST" class="my-login-validation" novalidate="" action="login.php">
								<div class="form-group">
									<label for="email">Username</label>
									<input id="email" type="email" class="form-control" name="txt_username" value="" required autofocus>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="txt_pass" required data-eye>
								</div>
								<div class="form-group m-0">
									<button type="submit" name="submit" class="btn btn-success btn-block">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="../js/my-login.js"></script>
</body>
</html>
