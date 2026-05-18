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
	<title>Agent Performance Report</title>
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>
	
	<h1>Agents Performance Report</h1>
	<h3>Report on the basis of performance</h3>

<div>
	<h4>Deliveries Completed by Agents</h4>
	<?php if(count($completedAgents)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Total Deliveries</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($completedAgents as $completedAgent){ ?>
				<tr>
					<td><?php echo $completedAgent['agent_id'] ?></td>
					<td><?php echo $completedAgent['agent_name'] ?></td>
					<td><?php echo $completedAgent['total_deliveries'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Agent Has Completed Any Delivery"; ?></div>
	<?php } ?>
</div>

<div>
	<h4>Failed Deliveries by Agents</h4>
	<?php if(count($failedAgents)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Total Assignments</th>
				<th>Failed Deliveries</th>
				<th>Failed Rate Percentage</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($failedAgents as $failedAgent){ ?>
				<tr>
					<td><?php echo $failedAgent['agent_id'] ?></td>
					<td><?php echo $failedAgent['agent_name'] ?></td>
					<td><?php echo $failedAgent['total_jobs'] ?></td>
					<td><?php echo $failedAgent['failed_deliveries'] ?></td>
					<td><?php echo $failedAgent['failed_rate_percent'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Agent Has Failed in Any Delivery"; ?></div>
	<?php } ?>
</div>
<div>
	<h4>Average Time per Agent</h4>
	<?php if(count($timeAgents)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Average Delivery Time</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($timeAgents as $timeAgent){ ?>
				<tr>
					<td><?php echo $timeAgent['agent_id'] ?></td>
					<td><?php echo $timeAgent['agent_name'] ?></td>
					<td><?php echo $timeAgent['avg_delivery_time_minutes'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
		</tbody>
		</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Agent Has Been Assigned"; ?></div>
	<?php } ?>
</div>
</mainBody>
</body>
</html>