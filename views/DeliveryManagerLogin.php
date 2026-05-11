<?php
	session_start();

	if($_SESSION['isLogged']){
		header('../views/DeliveryManagerDashboard.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delivery Manager Login Page</title>
</head>
<body>
	<form method="post" onsubmit="return checkLoginFields(this)" action= "../controller/DeliveryManagerLoginController.php">
		<h1>Deliver Manager Login</h1>
		<table>
			<tr>
				<td>
					<label for="userPhone" >Phone Number: </label>
					<br><br>
				</td>
				<td>
					<input type="text" name="userPhone" id="userPhone" >
					<br><br>
				</td>
				<td>
					<span id="userPhoneErr"></span>
					<br><br>
				</td>
			</tr>
			<tr>
				<td>
					<label for="userPass" >Password: </label>
					<br><br>
				</td>
				<td>
					<input type="password" name="userPass" id="userPass">
					<br><br>
				</td>
				<td>
					<span id="userPassErr"></span>
					<br><br>
				<td>
			</tr>
		</table>
		<input type="submit" value="Login">  
	</form>
	<br><br>
	<div id="msg"><?php echo isset($_SESSION['loginMsg']) ? $_SESSION['loginMsg'] : "";
	unset($_SESSION['loginMsg']);
	?></div>

	<script src=" ../asset/checkLogin.js"></script>

</body>
	
</html>