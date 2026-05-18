<?php
	session_start();
	if(!isset($_SESSION['isLogged']) || !$_SESSION['isLogged']){
		header('Location: ../controller/DeliveryManagerLoginController.php');
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome <?php echo $_SESSION['username'] ?></title>
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>

	<h1>Delivery Manager Dashboard</h1>
	<h3>Welcome <?php echo $_SESSION['username'] ?>!</h3>
	<div>
		Pending Dispatch Count<br>
		<?php echo $pendingDispatch ?><br>
	</div>
	<div>
		Active Deliveries<br>
		<?php echo $activeDelivery ?><br>
	</div>
	<div>
		Delivered Today<br>
		<?php echo $deliveredToday ?><br>
	</div>

</mainBody>
	

</body>
</html>