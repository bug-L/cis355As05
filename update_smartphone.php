<?php

session_start();
require 'database.php';

if(!$_SESSION['user_id']) {
    header("Location: login.php");
} 

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: my_smartphones.php");
}
    
if ( !empty($_POST)) {
    // keep track validation errors
    $brandError = null;
    $modelError = null;
    $priceError = null;
    
    // initialize $_POST variables
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    
    
    // validate user input
    $valid = true;
    if (empty($brand)) {
        $brandError = 'Please enter SmartPhone brand';
        $valid = false;
    }
    if (empty($model)) {
        $modelError = 'Please enter SmartPhone model';
        $valid = false;
    }
    if (empty($price)) {
        $priceError = 'Please enter SmartPhone price';
        $valid = false;
    } elseif ($price < 1 || $priceError > 10000) {
        $priceError = 'Price must be between $1 and $10,000';
    }
    
    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE smartphones SET brand = ?, model = ?, price = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($brand,$model,$price,$id));
        Database::disconnect();
        header("Location: my_smartphones.php");    
    }

} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM smartphones where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $brand = $data['brand'];
    $model = $data['model'];
    $price = $data['price'];
    Database::disconnect();
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
			
			<div class="row">
				<h3>Sell Your SmartPhone</h3>
			</div>
	
			<form class="form-horizontal" action="update_smartphone.php?id=<?php echo $id?>" method="post">

				<div class="control-group <?php echo !empty($brandError)?'error':'';?>">
					<label class="control-label">Brand</label>
					<div class="controls">
						<input name="brand" type="text"  placeholder="e.g. Apple" value="<?php echo !empty($brand)?$brand:'';?>">
						<?php if (!empty($brandError)): ?>
							<span class="help-inline"><?php echo $brandError;?></span>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($modelError)?'error':'';?>">
					<label class="control-label">Model</label>
					<div class="controls">
						<input name="model" type="text"  placeholder="e.g. iPhone 8" value="<?php echo !empty($model)?$model:'';?>">
						<?php if (!empty($modelError)): ?>
							<span class="help-inline"><?php echo $modelError;?></span>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="control-group <?php echo !empty($priceError)?'error':'';?>">
					<label class="control-label">Price</label>
					<div class="controls">
						<input name="price" type="number" min="1" max="10000" value="<?php echo !empty($price)?$price:'';?>">
						<?php if (!empty($priceError)): ?>
							<span class="help-inline"><?php echo $priceError;?></span>
						<?php endif;?>
					</div>
				</div>
			  
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Update SmartPhone</button>
					<a class="btn" href="my_smartphones.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
  </body>
</html>