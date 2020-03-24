<?php 
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: home.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">

		<div class="span10 offset1">
			
			<div class="row" style="text-align: center;">
                <h2>Welcome to SmartphoneSales!</h2>
                <a class="btn btn-primary" href="login.php">Login</a>
                <a class="btn btn-success" href="register.php">Register</a>
			</div>

			
		</div>
				
    </div>
  </body>
</html>