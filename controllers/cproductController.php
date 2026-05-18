<?php

session_start();

if(!isset($_SESSION['user_id']))
{
	header("Location: ../views/clogin.php");
	exit();
}

if($_SESSION['role'] != 'customer')
{
	header("Location: ../views/clogin.php");
    exit();
}

require_once "../config/connect.php";
require_once "../models/cproductModel.php";

$conn = connect();
if($conn)
{
	$products = getAllProducts($conn);
}
else
{
	$products = [];
}
mysqli_close($conn);



require "../views/cproducts.php";

?>