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
	<title>Add New Zone</title>
</head>
<body>

	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<h1>Add New Zone</h1>

	<form method="post" action="../controller/DeliveryManagerNewZoneController.php" onsubmit="return checkNewZone(this)">
		 <!--  -->
		<table>
			<tr>
				<td>
					<label for="zName" >Zone Name: </label>
					<br><br>
				</td>
				<td>
					<input type="text" name="zName" id="zName">
					<br><br>
				</td>
				<td>
					<span id="zNameErr"><?php echo isset($zoneNameErr) ? $zoneNameErr : ""; ?></span>
					<br><br>
				</td>
			</tr>
			<tr>
				<td>
					<label for="zDelFee" >Delivery Fee: </label>
					<br><br>
				</td>
				<td>
					<input type="text" name="zDelFee" id="zDelFee">
					<br><br>
				</td>
				<td>
					<span id="aDelFeeErr"><?php echo isset($zoneDelFeeErr) ? $zoneDelFeeErr : ""; ?></span>
					<br><br>
				</td>
			</tr>
			<tr>
				<td>
					<label for="zEstDays" >Estimated Days: </label>
					<br><br>
				</td>
				<td>
					<input type="text" name="zEstDays" id="zEstDays">
					<br><br>
				</td>
				<td>
					<span id="zEstDaysErr"><?php echo isset($zoneEstDaysErr) ? $zoneEstDaysErr : ""; ?></span>
					<br><br>
				</td>
			</tr>
			
		</table>

		<input type="submit" value="Add">

	</form>
	<div id="dupMsg">
		<?php echo isset($dupMsg) ? $dupMsg : ""; ?>		
	</div>

	<script src="../asset/js/DeliveryManagerCheckNewZone.js"></script>

</body>
</html>