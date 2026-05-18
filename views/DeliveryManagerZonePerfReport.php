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
	<title>Zone Performance Report</title>
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>
	
	<h1>Zone Performance Report</h1>
	<h3>Report based on zones</h3>
	
	<div>
	<h4>Deliveries per Zone</h4>
	<?php if(count($deliveryZones)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Total Deliveries</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($deliveryZones as $deliveryZone){ ?>
				<tr>
					<td><?php echo $deliveryZone['zone_id'] ?></td>
					<td><?php echo $deliveryZone['zone_name'] ?></td>
					<td><?php echo $deliveryZone['total_deliveries'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Order Has Been Delivered"; ?></div>
	<?php } ?>
</div>

<div>
	<h4>Average Delivery Time per Zone</h4>
	<?php if(count($timeZones)>0){ ?>
		<table>
			<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Average Delivery Time</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($timeZones as $timeZone){ ?>
				<tr>
					<td><?php echo $timeZone['zone_id'] ?></td>
					<td><?php echo $timeZone['zone_name'] ?></td>
					<td><?php echo $timeZone['avg_delivery_time_minutes'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Order Has Been Dispatched"; ?></div>
	<?php } ?>
</div>
</mainBody>
</body>
</html>