<?php
 session_start();

 require_once "../config/connect.php";
 require_once "../models/cproductModel.php";
 require_once "../models/ccartModel.php";

 if(!isset($_SESSION['user_id']))
 {
 	header("Location:../views/clogin.php");
 	exit();
 }

 if(isset($_GET['action']))
 {
 	$action = $_GET['action'];
 }
 else
 {
 	$action = "";
 }

 $conn = connect();

 if($action == "add")
 {
 	if(isset($_GET['id']))
 	{
 		$id = $_GET['id'];
 	}
 	else
 	{
 		$id = 0;
 	}
 	$sql = "SELECT * FROM products WHERE id=$id LIMIT 1";
 	$result = mysqli_query($conn, $sql);
 	$product = mysqli_fetch_assoc($result);
 	if($product)
	{
		addToCart($product);
	}

 	header("Location:../controllers/cproductController.php");
 	exit();
 }

 if($action == "view")
 {
 	$cart = getCart();
 	$_SESSION['cart'] = $cart;
 	header("Location:../views/ccart.php");
 	exit();
 }

 if($action == "remove")
 {
 	if(isset($_GET['id']))
 	{
 		$id = $_GET['id'];
 	}
 	else
 	{
 		$id = 0;
 	}
 	removeFromCart($id);
 	header("Location:../controllers/ccartController.php?action=view");
 	exit();
 }

 if($action == "update")
 {
 	if(isset($_GET['id']))
 	{
 		$id = $_GET['id'];
 	}
 	else
 	{
 		$id = 0;
 	}
 	if(isset($_GET['qty']))
 	{
 		$qty = $_GET['qty'];
 	}
 	else
 	{
 		$qty = 1;
 	}
 	updateCart($id, $qty);
 	header("Location:../controllers/ccartController.php?action=view");
 	exit();
 }

 mysqli_close($conn);
 exit();

?>