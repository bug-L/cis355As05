<?php
session_start();

require 'database.php';

if(!$_SESSION['user_id']) {
    header("Location: login.php");
}

if ( !empty($_GET['id'])) {
    $smartphone_id = $_GET['id'];
    $sql = "SELECT * FROM smartphones WHERE id = ? LIMIT 1";
    $pdo = Database::connect();
    $q = $pdo->prepare($sql);
    $q->execute(array($smartphone_id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}
    
if ( !empty($_POST)) {
    // keep track post values
    $buyer_id = $_SESSION['user_id'];
    $smartphone_id = $_POST['smartphone_id'];
    // attach to db
    $pdo = Database::connect();
    
    //verify this user is not already interested
    $sql = "SELECT * FROM transaction";

    foreach($pdo->query($sql) as $row) {

		if($buyer_id == $row['buyer_id'] && $smartphone_id == $row['smartphone_id']) {
            header("Location: my_smartphones.php");
            exit();
		}
	}
    

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO transaction (smartphone_id, buyer_id) values(?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($smartphone_id, $buyer_id));
    
    Database::disconnect();
    header("Location: my_smartphones.php");
        
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
     
        <div class="span10 offset1">
            <div class="row">
                <h3>Interested in <?php echo $data['brand'] . ' ' . $data['model'] . '?'; ?></h3>
            </div>
                
            <form class="form-horizontal" action="buy_smartphone.php" method="post">
                <input type="hidden" name="smartphone_id" value="<?php echo $smartphone_id;?>"/>
                <p>Phone will be added to your profile.</p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Yes</button>
                    <a class="btn" href="browse.php">No</a>
                </div>
            </form>
        </div>
                 
    </div> <!-- /container -->
  </body>
</html>