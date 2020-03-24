<?php 

session_start();
require 'database.php';

if(!$_SESSION['user_id']) {
    
    header("Location: login.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Browse Smartphones</h3>
            </div>
            <div class="row">
			
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Brand</th>
                      <th>Model</th>
                      <th>Price</th>
					  <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $pdo = Database::connect();
    
                    $id = $_SESSION['user_id'];
                    $sql = "SELECT * FROM smartphones WHERE NOT user_id='$id'";
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['brand'] . '</td>';
                            echo '<td>'. $row['model'] . '</td>';
                            echo '<td> $'. $row['price'] . '</td>';
							              echo '<td>';
							              echo '<a class="btn btn-success" href="buy_smartphone.php?id='.$row['id'].'">Interested</a>';
							
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>