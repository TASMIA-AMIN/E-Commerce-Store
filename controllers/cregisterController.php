<?php
session_start();

require_once "../config/connect.php";
require_once "../models/userModel.php";

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password =$_POST['password'];

$message = $nameErr = $emailErr = $phoneErr = $passwordErr = "";
$valid = true;

if(empty($name))
{
	$nameErr="Name is required";
	$valid=false;
}

if(empty($email))
{
	$emailErr="email is required";
	$valid=false;
}

if(empty($phone))
{
	$phoneErr="Phone is required";
	$valid=false;
}

if(empty($password))
{
	$passwordErr="Password is required";
	$valid=false;
}

if($valid)
{
	$conn = connect();
	createUser($conn, $name, $email, $phone, $password);
	mysqli_close($conn);
	$_SESSION['message'] = "Registration successful! Please login.";

	header("Location: ../views/clogin.php");
	exit();
}
else
{
	$_SESSION['message'] = "All fields are required!";
    $_SESSION['nameErr'] = $nameErr;
    $_SESSION['phoneErr'] = $phoneErr;
    $_SESSION['passwordErr'] = $passwordErr;

	
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;

    header("Location: ../views/cregister.php");
    exit();
}

?>