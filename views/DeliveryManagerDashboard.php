<?php
	session_start();
	if(!isset($_SESSION['isLogged']) || !$_SESSION['isLogged']){
		header('Location: ../views/DeliveryManagerLogin.php');
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome <?php echo $_SESSION['username'] ?></title>
</head>
<body>

	<?php require '../views/DeliveryManagerSideBar.php' ?>

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
	

</body>
</html>