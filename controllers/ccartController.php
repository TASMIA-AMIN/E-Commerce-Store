<?php

session_start();

require_once "../models/ccartModel.php";

$action = $_GET['action'];

if($action == "add")
{
	$id = $_GET['id'];
	$name = $_GET['name'];
	$price = $_GET['price'];
	addToCart($id, $name, $price);
	header("Location: ../views/cproducts.php");
	exit();
}

if($action == "view")
{
	$cart = getCart();
	$_SESSION['cart_data'] = $cart;
	header("Location: ../views/ccart.php");
	exit();
}

if($action == "remove")
{
	$index = $_GET['index'];
	removeFromCart($index);
	header("Location: ../controllers/ccartController.php?action=view");
	exit();

}

?>