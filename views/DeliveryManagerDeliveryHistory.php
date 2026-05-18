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
	<title>Delivery History</title>
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>
	
	<h1>Delivery History</h1>
	<p>All completed and failed deliveries</p>
	
	<?php if(count($deliveries)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th> Assignment ID</th>
				<th>Order ID</th>
				<th>Shipping Address</th>
				<th>Agent Name</th>
				<th>Agent Phone</th>
				<th>Vehicle Type</th>
				<th>Zone Name</th>
				<th>Delivery Fee</th>
				<th>Delivery Status</th>
				<th>Assigned At</th>
				<th>Order Created At</th>
				
			</tr>
			</thead>
			<tbody >	
			<?php foreach($deliveries as $delivery){ ?>
				<tr>
					<td><?php echo $delivery['assignment_id'] ?></td>
					<td><?php echo $delivery['order_id'] ?></td>
					<td><?php echo $delivery['shipping_address'] ?></td>
					<td><?php echo $delivery['agent_name'] ?></td>
					<td><?php echo $delivery['agent_phone'] ?></td>
					<td><?php echo $delivery['vehicle_type'] ?></td>
					<td><?php echo $delivery['zone_name'] ?></td>
					<td><?php echo $delivery['delivery_fee'] ?></td>
					<td><?php echo $delivery['delivery_status'] ?></td>
					<td><?php echo $delivery['assigned_at'] ?></td>
					<td><?php echo $delivery['order_created_at'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Delivery is Completed!"; ?></div>
	<?php } ?>
</mainBody>
</body>
</html>