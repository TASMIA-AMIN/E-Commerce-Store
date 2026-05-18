<?php
session_start();

require_once "../config/connect.php";
require_once "../models/cwishlistModel.php";

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

if($action == "add")
{
	$customer_id = $_SESSION['user_id'];

	if(isset($_GET['product_id']) && $_GET['product_id'] > 0)
	{
		$product_id = $_GET['product_id'];
		addWishlist($conn, $customer_id, $product_id);
	}

	header("Location: ../controllers/cproductController.php?action=view");
	exit();
}

 if($action == "view")
 {
 	$customer_id = $_SESSION['user_id'];
 	$wishlist = getWishlist($conn, $customer_id);
 	require "../views/cwishlist.php";
 	exit();
 }

 if($action == "remove")
 {
 	$customer_id = $_SESSION['user_id'];
 	if(isset($_GET['id']))
 	{
 		$wishlist_id = $_GET['id'];
 	}
 	else
 	{
 		$wishlist_id = 0;
 	}

 	removeWishlist($conn, $wishlist_id, $customer_id);
 	header("Location:../controllers/cwishlistController.php?action=view");
 	exit();
 }

 mysqli_close($conn);

?>