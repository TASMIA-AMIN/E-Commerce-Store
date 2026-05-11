<?php
	session_start();
	if(!$_SESSION['isLogged']){
		header('../views/DeliveryManagerDashboard.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome <?php echo $_SESSION['username'] ?></title>
</head>
<body>
	<?php echo $_SESSION['username'] ?>

</body>
</html>