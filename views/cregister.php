<?php
session_start();
$message = $nameErr = $emailErr = $phoneErr = $passwordErr = "";
$name = $email = $phone = "";

if (isset($_SESSION['message']))
{
	$message = $_SESSION['message'];
}
if (isset($_SESSION['nameErr']))
{
	$nameErr = $_SESSION['nameErr'];
}
if (isset($_SESSION['emailErr']))
{
	$emailErr = $_SESSION['emailErr'];
}
if (isset($_SESSION['phoneErr']))
{
	$phoneErr = $_SESSION['phoneErr'];
}
if (isset($_SESSION['passwordErr']))
{
	$passwordErr = $_SESSION['passwordErr'];
}
if (isset($_SESSION['name']))
{
	$name = $_SESSION['name'];
}
if (isset($_SESSION['email']))
{
	$email = $_SESSION['email'];
}
if (isset($_SESSION['phone']))
{
	$phone = $_SESSION['phone'];
}
unset($_SESSION['message']);
unset($_SESSION['nameErr']);
unset($_SESSION['emailErr']);
unset($_SESSION['phoneErr']);
unset($_SESSION['passwordErr']);
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['phone']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>CustomerRegister</title>
</head>
<body>
	<h2>Customer Register</h2>
	<p><?php echo $message; ?></p>

	<form method="POST" action="../controllers/cregisterController.php">

		<label for ="name">Name:</label>
		<input type="text" id="name" name="name" value="<?php echo $name; ?>">
		<?php echo $nameErr; ?>
		<br><br>

		<label for ="email">Email:</label>
		<input type="text" id="email" name="email" value="<?php echo $email; ?>">
		<?php echo $emailErr; ?>
		<br><br>

		<label for ="phone">Phone:</label>
		<input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
		<?php echo $phoneErr; ?>
		<br><br>

		<label for ="password">Password:</label>
		<input type="password" id="password" name="password">
		<?php echo $passwordErr; ?>
		<br><br>

		<input type="submit" value="Register">
	</form>
</body>
</html>


