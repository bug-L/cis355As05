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
                <h3>My Smartphones</h3>
            </div>
            <div class="row">
				<p>
                    <a href="home.php" class="btn btn-success">Home</a>
                </p>
                <h4>My Smartphones For Sale:</h4>
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
                    $sql = "SELECT * FROM smartphones WHERE user_id='$id'";
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['brand'] . '</td>';
                            echo '<td>'. $row['model'] . '</td>';
                            echo '<td> $'. $row['price'] . '</td>';
							echo '<td>';
                            echo '<a class="btn btn-success" href="update_smartphone.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete_smartphone.php?id='.$row['id'].'">Delete</a>';		
                   }
                   
                   Database::disconnect();
                  ?>
                  </tbody>
                </table>

                <br><br>

                <h4>Phones I'm Interested In:</h4>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Phone</th>
                      <th>Price</th>
                      <th>Seller Name</th>
                      <th>Seller Number</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $pdo = Database::connect();
    
                    $id = $_SESSION['user_id'];
                    $sql = "SELECT * FROM transaction WHERE buyer_id='$id'";
                   foreach ($pdo->query($sql) as $row) {
                        $sql = "SELECT * FROM smartphones WHERE id = ? LIMIT 1";
                        $q = $pdo->prepare($sql);
                        $q->execute(array($row['smartphone_id']));
                        $phone = $q->fetch(PDO::FETCH_ASSOC);
                        echo '<tr>';
                        echo '<td>'. $phone['brand'] . ' ' . $phone['model'] . '</td>';
                        echo '<td> $'. $phone['price'] . '</td>';
                            
                        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
                        $q = $pdo->prepare($sql);
                        $q->execute(array($phone['user_id']));
                        $user = $q->fetch(PDO::FETCH_ASSOC);
                        
                        echo '<td>'. $user['fname'] . ' ' . $user['lname'] . '</td>';
                        echo '<td>'. $user['mobile'] . '</td>';
                        echo '<td>';
                        echo '<a class="btn btn-danger" href="delete_transaction.php?id='.$row['id'].'">Remove</a>';
                   }

                   Database::disconnect();
                  ?>
                  </tbody>
                </table>
            </div>
    </div> <!-- /container -->
  </body>
</html>