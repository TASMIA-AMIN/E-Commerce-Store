<?php
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
	<title>Register New Agent</title>
</head>
<body>
	<h1>Register New Agent</h1>

	<form method="post" action="../controller/DeliveryManagerNewAgentController.php" onsubmit="return checkNewAgent(this)">
		 <!--  -->
		<table>
			<tr>
				<td>
					<label for="aName" >Agent Name: </label>
					<br><br>
				</td>
				<td>
					<input type="text" name="aName" id="aName">
					<br><br>
				</td>
				<td>
					<span id="aNameErr"><?php echo isset($agentNameErr) ? $agentNameErr : ""; ?></span>
					<br><br>
				</td>
			</tr>
			<tr>
				<td>
					<label for="aPhone" >Agent Phone Number: </label>
					<br><br>
				</td>
				<td>
					<input type="text" name="aPhone" id="aPhone">
					<br><br>
				</td>
				<td>
					<span id="aPhoneErr"><?php echo isset($agentPhoneErr) ? $agentPhoneErr : ""; ?></span>
					<br><br>
				</td>
			</tr>
			<tr>
				<td>
					<label for="aPhone" >Agent Vehicle Type: </label>
					<br><br>
				</td>
				<td>
					<select name="aVehicleType">

	    				<option value="bike">Bike</option>

	    				<option value="bicycle">Bicycle</option>

	    				<option value="scooter">Scooter</option>

	    				<option value="car">Car</option>

	    				<option value="van">Van</option>

					</select>
					<br><br>
				</td>
				<td>
					<br><br>
				</td>
			</tr>
		</table>

		<input type="submit" value="Register">

	</form>
	<div id="dupMsg">
		<?php echo isset($dupMsg) ? $dupMsg : ""; ?>		
	</div>

	<script src="../asset/js/DeliveryManagerCheckNewAgent.js"></script>

</body>
</html>