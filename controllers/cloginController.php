<?php
session_start();

require_once "../config/connect.php";
require_once "../models/userModel.php";

$email = $_POST['email'];
$password = $_POST['password'];

$message = "";
$emailErr = $passwordErr = "";
$valid = true;

if(empty($email))
{
	$emailErr = "Email is required";
	$valid = false;
}

if(empty($password))
{
	$passwordErr = "Password is required";
	$valid = false;
}

if($valid)
{
	$conn = connect();
	$user = loginUser($conn, $email, $password);

	mysqli_close($conn);
	if($user != null)
	{
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['user_name'] = $user['name'];
		$_SESSION['user_email'] = $user['email'];
		$_SESSION['role'] = $user['role'];

		header("Location:  ../views/cdashboard.php");
		exit();
	}
	else
	{
		$message = "Invalid email or password";
	}
}
else
{
	$message = "All fields are required!";
}

$_SESSION['message'] = $message;
$_SESSION['emailErr'] = $emailErr;
$_SESSION['passwordErr'] = $passwordErr;
$_SESSION['email'] = $email;
header("Location:  ../views/clogin.php");
exit();

?>