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
	<title>Manage Zones</title>
</head>
<body>

	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<div id="messageBox" style="display:none; padding:10px; margin-bottom:10px;"></div>

	<div id="confirmBox" style="display:none;"></div>
	
	<h1>Manage Zones</h1>
	<p>Add new zones and update information for preregistered zones</p>
	<a href="../controller/DeliveryManagerNewZoneController.php">
		<button>Add New Zone</button>
	</a>
	<?php if(count($zones)>0){ ?>
		<table>
			<thead>
			<tr>
				<th>ID</th>
				<th>Zone Name</th>
				<th>Delivery Fees</th>
				<th>Estimated Days</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($zones as $zone){ ?>
				<tr>
					<td><?php echo $zone['id'] ?></td>
					<td><?php echo $zone['zone_name'] ?></td>
					<td><?php echo $zone['delivery_fee'] ?></td>
					<td><?php echo $zone['estimated_days'] ?></td>
					<td><button onclick="showEdit(<?php echo $zone['id']; ?>)">Edit</button></td>
					<td><button onclick="deleteZone(<?php echo $zone['id']; ?>)">Delete</button></td>
				</tr>
			</div>
				<tr id="editRow<?php echo $zone['id']; ?>" style="display:none;">
					<td colspan="6">
						<table>
							<tr>
								<td>
									<label for="zNameEdit<?php echo $zone['id']; ?>">Zone Name: </label>
									<br><br>
								</td>
								<td>
									<input type="text" id="zNameEdit<?php echo $zone['id']; ?>" value="<?php echo $zone['zone_name'] ?>" >
									<br><br>
								</td>
							</tr>
							<tr>
								<td>
									<label for="zDelFeeEdit<?php echo $zone['id']; ?>" >Delivery Fees: </label>
									<br><br>
								</td>
								<td>
									<input type="text" id="zDelFeeEdit<?php echo $zone['id']; ?>" value="<?php echo $zone['delivery_fee'] ?>">
									<br><br>
								</td>
							</tr>
							<tr>
								<td>
									<label for="zEstDaysEdit<?php echo $zone['id']; ?>" >Estimated Days: </label>
									<br><br>
								</td>
								<td>
									<input type="text" id="zEstDaysEdit<?php echo $zone['id']; ?>" value="<?php echo $zone['estimated_days'] ?>">
									<br><br>
								</td>
							</tr>
							
						</table>

						<button onclick="updateZone(<?php echo $zone['id']; ?>)">Update</button>
						<button onclick="hideEdit(<?php echo $zone['id']; ?>)">Cancel</button>
						<br><br>
				</div>
			<?php } ?>
			
		</table>
	</td>
</tr>
</tbody>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Zone is Registered"; ?></div>
	<?php } ?>

	<script src="../asset/js/DeliveryManagerEditZone.js"></script>
	

</body>
</html>