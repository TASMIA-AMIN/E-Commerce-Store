<?php
session_start();

require_once "../config/connect.php";
require_once "../models/corderModel.php";

if(!isset($_SESSION['user_name']))
{
	header("Location: ../views/clogin.php");
	exit();
}

$conn = connect();

$action = "";

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}


if($action == "place")
{
	$cart = array();

	if(isset($_SESSION['cart']))
	{
		$cart = $_SESSION['cart'];
	}

	if(empty($cart))
	{
		header("Location: ../controllers/cproductController.php");
		exit();
	}

	$user_id = $_SESSION['user_id'];
	$address = $_POST['address'];
	$delivery_zone = $_POST['delivery_zone'];
	$payment_method = $_POST['payment_method'];

	$subtotal = 0;

	foreach($cart as $c)
	{
		$subtotal = $subtotal + ($c['price'] * $c['qty']);
	}

	$total = $subtotal;

	$order_id = createOrder($conn, $user_id, $address, $delivery_zone, $payment_method, $subtotal, $total);

	saveOrderItems($conn, $order_id, $cart);

	unset($_SESSION['cart']);
	$_SESSION['order_id'] = $order_id;

	header("Location: ../views/corderSuccess.php");
	exit();
}


if($action == "list")
{
	$user_id = $_SESSION['user_id'];

	$sql = "SELECT * FROM orders WHERE customer_id='$user_id' ORDER BY id DESC";
	$result = mysqli_query($conn, $sql);

	if(!$result)
	{
		die("Query Error: " . mysqli_error($conn));
	}

	$orders = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$orders[] = $row;
	}

	require "../views/corders.php";
}


if($action == "details")
{
	$order_id = 0;

   if(isset($_GET['id']) && $_GET['id'] > 0)
      {
      	$order_id = $_GET['id'];
      }
	$user_id = $_SESSION['user_id'];

	$sql1 = "SELECT * FROM orders WHERE id='$order_id' AND customer_id='$user_id'";
	$result1 = mysqli_query($conn, $sql1);

	$order = mysqli_fetch_assoc($result1);

	$sql2 = "SELECT * FROM order_items WHERE order_id='$order_id'";
	$result2 = mysqli_query($conn, $sql2);

	if(!$result2)
	{
		die("Query Error: " . mysqli_error($conn));
	}

	$items = array();

	while($row = mysqli_fetch_assoc($result2))
	{
		$items[] = $row;
	}

	require "../views/corderDetail.php";
}

if($action == "checkout")
{
	if(!isset($_SESSION['cart']) || empty($_SESSION['cart']))
	{
		header("Location: ../controllers/cproductController.php");
		exit();
	}

	$cart = $_SESSION['cart'];

	require "../views/ccheckout.php";
	exit();
}

mysqli_close($conn);
?>