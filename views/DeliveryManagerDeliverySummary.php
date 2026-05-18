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
	<title>Delivery Summary</title>
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>
	
	<h1>Delivery Summary</h1>
	<p>Daily and weekly summary of deliveries</p>
	
	<div>
		<h3>Daily Summary</h3><br>
		Total Delivered today: <?php echo $daily['total_delivered'] ?><br>
		Total Failed today: <?php echo $daily['total_failed'] ?><br>
		Total In-Transit today: <?php echo $daily['total_in_transit'] ?><br>
		Total Deliveries today: <?php echo $daily['total_deliveries'] ?><br>
	</div>
	<div>
		<h3>Weekly Summary</h3><br>
		Total Delivered this week: <?php echo $weekly['total_delivered'] ?><br>
		Total Failed this week: <?php echo $weekly['total_failed'] ?><br>
		Total In-Transit this week: <?php echo $weekly['total_in_transit'] ?><br>
		Total Deliveries this week:<?php echo $weekly['total_deliveries'] ?><br>
	</div>
</mainBody>
</body>
</html>