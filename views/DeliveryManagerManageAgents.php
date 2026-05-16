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
	<title>Manage Agents</title>
</head>
<body>
	<h1>Manage Agents</h1>
	<p>Register new agents and update information for preregistered agents</p>
	<a href="../controller/DeliveryManagerNewAgentController.php">
		<button>Add New Agent</button>
	</a>
	<?php if(count($agents)>0){ ?>
		<table>
			<tr>
				<th>ID</th>
				<th>Registered By</th>
				<th>Name</th>
				<th>Phone</th>
				<th>Vehicle Type</th>
			</tr>	
			<?php foreach($agents as $agent){ ?>
				<tr>
					<td><?php echo $agent['id'] ?></td>
					<td><?php echo $agent['user_id'] ?></td>
					<td><?php echo $agent['name'] ?></td>
					<td><?php echo $agent['phone'] ?></td>
					<td><?php echo $agent['vehicle_type'] ?></td>
					<td><button onclick="agentEdit()">Edit</button></td>
					<td><button onclick="agentStatusChange(<?php echo $agent['id']; ?>, this)">
						<?php echo $agent['is_active'] ? "Deactivate" : "Activate"; ?>
					</button></td>
				</tr>
			<?php } ?>
		</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Agent is Registered"; ?></div>
	<?php } ?>

	<script src="../asset/js/DeliveryManagerEditActivateAgent.js"></script>
	

</body>
</html>