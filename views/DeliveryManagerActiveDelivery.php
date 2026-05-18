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
	<title>Active Deliveries</title>
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>

	<div id="messageBox" style="display:none; padding:10px; margin-bottom:10px;"></div>

	<div id="confirmBox" style="display:none;"></div>
	
	<h1>Active Deliveries</h1>
	<p>Deliveries that are already dispatched</p>

	<?php if(count($assignments)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th>Assignment ID</th>
				<th>Order ID</th>
				<th>Shipping Address</th>
				<th>Agent Name</th>
				<th>Agent Vehicle</th>
				<th>Agent Phone</th>
				<th>Zone Name</th>
				<th>Order Status</th>
				<th>Minute Since Assignment</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($assignments as $assignment){ ?>
				<tr>
					<td><?php echo $assignment['assignment_id'] ?></td>
					<td><?php echo $assignment['order_id'] ?></td>
					<td><?php echo $assignment['shipping_address'] ?></td>
					<td><?php echo $assignment['agent_name'] ?></td>
					<td><?php echo $assignment['vehicle_type'] ?></td>
					<td><?php echo $assignment['agent_phone'] ?></td>
					<td><?php echo $assignment['zone_name'] ?></td>
					<td><?php echo $assignment['status'] ?></td>
					<td><?php echo $assignment['minutes_since_assignment'] ?></td>

					<td><button onclick="showEdit(<?php echo $assignment['assignment_id']; ?>)">Change Status</button></td>
				</tr>
				<tr id="editRow<?php echo $assignment['assignment_id']; ?>" style="display:none;">
					<td colspan="10">
						<table>
							<tr>
								<td>
									<label for="assignStatus<?php echo $assignment['assignment_id']; ?>">Status </label>
									<br><br>
								</td>
								<td>

									<select id="assignStatus<?php echo $assignment['assignment_id']; ?>">

									    <?php if($assignment['status'] == "assigned"){ ?>

									        <option value="picked_up">Picked Up</option>

									    <?php } ?>

									    <?php if($assignment['status'] == "picked_up"){ ?>

									        <option value="in_transit">In Transit</option>

									    <?php } ?>

									    <?php if($assignment['status'] == "in_transit"){ ?>

									        <option value="delivered">Delivered</option>
									        <option value="failed">Failed</option>

									    <?php } ?>

									</select>

									<br><br>
								</td>
							</tr>
							
						</table>

						<button onclick="changeStatus(<?php echo $assignment['assignment_id']; ?>)">Change Status</button>
						<button onclick="hideEdit(<?php echo $assignment['assignment_id']; ?>)">Cancel</button>
						<br><br>
			<?php } ?>
			
		</table>
	</td>
</tr>
</tbody>
</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Dispatched Order!!!"; ?></div>
	<?php } ?>


	<script src="../asset/js/DeliveryManagerChangeOrderStatus.js"></script>
	</mainBody>

</body>
</html>