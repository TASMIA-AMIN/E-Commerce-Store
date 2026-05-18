<?php
session_start();

require_once "../config/connect.php";
require_once "../models/cprofileModel.php";

if(!isset($_SESSION['user_name']))
{
	header("Location: clogin.php");
	exit();
}
 $conn = connect();

$action = "";
if(isset($_GET['action']))
 {
 	$action = $_GET['action'];
 }

 if($action == "view")
 {
 	$user_id = $_SESSION['user_id'];
 	$user = getUserById($conn, $user_id);
 	require "../views/cprofile.php";
 }

 if($action == "update")
 {
 	$user_id = $_SESSION['user_id'];
 	$name = $_POST['name'];
 	$email = $_POST['email'];
 	$phone = $_POST['phone'];

 	$profile_pic = "";
 	if(isset($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['name'] != "")
 	{
 		$profile_pic = "uploads/" . $_FILES['profile_pic']['name'];
 		move_uploaded_file($_FILES['profile_pic']['tmp_name'], "../" . $profile_pic);
 	}
 	else
 	{
 		$profile_pic = $_SESSION['profile_pic'];
 	}

 	updateProfile($conn, $user_id, $name, $email, $phone, $profile_pic);

 	$_SESSION['user_name'] = $name;
 	$_SESSION['profile_pic'] = $profile_pic;

 	header("Location:../controllers/cprofileController.php?action=view");
 	exit(); 
 }

 if($action == "password")
{
	$user_id = $_SESSION['user_id'];

	$new_password = $_POST['new_password'];

	updatePassword($conn, $user_id, $new_password);

	header("Location:../controllers/cprofileController.php?action=view");
	exit();
}

 mysqli_close($conn);

?>