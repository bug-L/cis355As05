<?php

session_start(); 
require 'database.php';

//check if logged in

if($_SESSION['user_id']) {
    //retrieve image
    $id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
} else {
    
    header("Location: login.php");

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
                <h3>Welcome, <?php echo $data['fname'] . ' ' . $data['lname']; ?>!</h3>
                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $data['filecontent'] ).'" style="height: 200px; width: auto;" alt="Profile Picture"/>'; ?>
                    
                <br>
                <h4>What would you like to do?</h4><br>
                <a href="browse.php" class="btn btn-primary">Browse SmartPhones</a><br><br>
                <a href="sell_smartphone.php" class="btn btn-success">Sell Your SmartPhone</a><br><br>
                <a href="my_smartphones.php" class="btn">Your SmartPhones</a><br><br>
                <hr>
                <a href="update_user.php" class="btn">Update Info</a> 
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
            
        </div> 
        
				
    </div> 
  </body>
  
</html>
	

	