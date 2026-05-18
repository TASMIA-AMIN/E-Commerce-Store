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
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>

	<div id="messageBox" style="display:none; padding:10px; margin-bottom:10px;"></div>

	
	<h1>Manage Agents</h1>
	<p>Register new agents and update information for preregistered agents</p>
	<a href="../controller/DeliveryManagerNewAgentController.php">
		<button>Add New Agent</button>
	</a>
	<?php if(count($agents)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th>ID</th>
				<th>Registered By</th>
				<th>Name</th>
				<th>Phone</th>
				<th>Vehicle Type</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($agents as $agent){ ?>
				<tr id="agentTable">
					<td><?php echo $agent['id'] ?></td>
					<td><?php echo $agent['user_id'] ?></td>
					<td><?php echo $agent['name'] ?></td>
					<td><?php echo $agent['phone'] ?></td>
					<td><?php echo $agent['vehicle_type'] ?></td>
					<td><button onclick="showEdit(<?php echo $agent['id']; ?>)">Edit</button></td>
					<td><button onclick="agentStatusChange(<?php echo $agent['id']; ?>, this)">
						<?php echo $agent['is_active'] ? "Deactivate" : "Activate"; ?>
					</button></td>
				</tr>
			</div>
				<tr id="editRow<?php echo $agent['id']; ?>" style="display:none;">
					<td colspan="6">
						<table>
							<tr>
								<td>
									<label for="aNameEdit<?php echo $agent['id']; ?>">Agent Name: </label>
									<br><br>
								</td>
								<td>
									<input type="text" id="aNameEdit<?php echo $agent['id']; ?>" value="<?php echo $agent['name'] ?>" >
									<br><br>
								</td>
								<td>
									<span id="aNameEditErr"><?php echo isset($agentNameErr) ? $agentNameErr : ""; ?></span>
									<br><br>
								</td>
							</tr>
							<tr>
								<td>
									<label for="aPhoneEdit<?php echo $agent['id']; ?>" >Agent Phone Number: </label>
									<br><br>
								</td>
								<td>
									<input type="text" id="aPhoneEdit<?php echo $agent['id']; ?>" value="<?php echo $agent['phone'] ?>">
									<br><br>
								</td>
								<td>
									<span id="aPhoneErr"><?php echo isset($agentPhoneErr) ? $agentPhoneErr : ""; ?></span>
									<br><br>
								</td>
							</tr>
							<tr>
								<td>
									<label for="aVehicleEdit<?php echo $agent['id']; ?>" >Agent Vehicle Type: </label>
									<br><br>
								</td>
								<td>
									<select name="aVehicleType" id="aVehicleEdit<?php echo $agent['id']; ?>" value="<?php echo $agent['vehicle_type'] ?>">

					    				<option value="bike" <?php if($agent['vehicle_type'] == "bike") echo "selected"; ?>> Bike </option>

									    <option value="bicycle" <?php if($agent['vehicle_type'] == "bicycle") echo "selected"; ?>> Bicycle </option>

									    <option value="scooter" <?php if($agent['vehicle_type'] == "scooter") echo "selected"; ?>> Scooter </option>

									    <option value="car" <?php if($agent['vehicle_type'] == "car") echo "selected"; ?>> Car </option>

									    <option value="van" <?php if($agent['vehicle_type'] == "van") echo "selected"; ?>> Van </option>

									</select>
									<br><br>
								</td>
								<td>
									<br><br>
								</td>
							</tr>
						</table>

						<button onclick="updateAgent(<?php echo $agent['id']; ?>)">Update</button>
						<button onclick="hideEdit(<?php echo $agent['id']; ?>)">Cancel</button>
						<br><br>
				</div>
			<?php } ?>
			
		</table>
	</td>
</tr>
</tbody>
</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Agent is Registered"; ?></div>
	<?php } ?>
</mainBody>

	<script src="../asset/js/DeliveryManagerEditActivateAgent.js"></script>
	

</body>
</html>