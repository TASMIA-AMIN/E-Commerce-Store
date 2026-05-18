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
	<title>View Agents</title>
</head>
<body>

	<?php require '../views/DeliveryManagerSideBar.php' ?>
	
	<h1>View Agents</h1>
	<p>View all agent details along with their delivery count</p>
	
	<?php if(count($agents)>0){ ?>
		<table>
			<thead>
			<tr>
				<th>ID</th>
				<th>Registered By</th>
				<th>Name</th>
				<th>Phone</th>
				<th>Vehicle Type</th>
				<th>Created At</th>
				<th>Active Delivery</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($agents as $agent){ ?>
				<tr>
					<td><?php echo $agent['id'] ?></td>
					<td><?php echo $agent['name'] ?></td>
					<td><?php echo $agent['agent_name'] ?></td>
					<td><?php echo $agent['phone'] ?></td>
					<td><?php echo $agent['vehicle_type'] ?></td>
					<td><?php echo $agent['created_at'] ?></td>
					<td><?php echo $agent['active_deliveries'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Agent is Registered"; ?></div>
	<?php } ?>
</body>
</html>