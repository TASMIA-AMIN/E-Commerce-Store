<?php
session_start();

$message = $emailErr = $passwordErr ="";
$email = "";

if (isset($_SESSION['message']))
{
	$message = $_SESSION['message'];
}

if (isset($_SESSION['emailErr']))
{
	$emailErr = $_SESSION['emailErr'];
}

if (isset($_SESSION['passwordErr']))
{
	$passwordErr = $_SESSION['passwordErr'];
}

if (isset($_SESSION['email']))
{
	$email = $_SESSION['email'];
}

unset($_SESSION['message']);
unset($_SESSION['emailErr']);
unset($_SESSION['passwordErr']);
unset($_SESSION['email']);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Login</title>
</head>
<body>
	<h2>Customer Login</h2>
	<p><?php echo $message; ?></p>
	<form method="POST" action="../controllers/cloginController.php">
		<label for ="email">Email:</label>
		<input type="text" id="email" name="email" value="<?php echo $email; ?>">
		<?php echo $emailErr; ?>
		<br><br>
		<label for ="password">Password:</label>
		<input type="password" id="password" name="password">
		<?php echo $passwordErr; ?>
		<br><br>
		<input type ="submit"  value="Login">
	</form>
</body>
</html>


