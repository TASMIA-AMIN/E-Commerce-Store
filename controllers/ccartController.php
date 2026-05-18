<?php
session_start();

require_once "../config/connect.php";

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


if($action == "add")
{
	if(!isset($_GET['product_id']))
	{
		die("product_id missing");
	}

	$product_id = $_GET['product_id'];

	$sql = "SELECT id, name, price FROM products WHERE id='$product_id'";
	$result = mysqli_query($conn, $sql);
	$product = mysqli_fetch_assoc($result);

	if(!$product)
	{
		die("Product not found");
	}

	if(!isset($_SESSION['cart']))
	{
		$_SESSION['cart'] = array();
	}

	$found = 0;

	for($i = 0; $i < count($_SESSION['cart']); $i++)
	{
		if($_SESSION['cart'][$i]['id'] == $product_id)
		{
			$_SESSION['cart'][$i]['qty'] = $_SESSION['cart'][$i]['qty'] + 1;
			$found = 1;
			break;
		}
	}

	if($found == 0)
	{
		$_SESSION['cart'][] = array(
			'id' => $product['id'],
			'name' => $product['name'],
			'price' => $product['price'],
			'qty' => 1
		);
	}

	header("Location: ../controllers/ccartController.php?action=view");
	exit();
}

if($action == "view")
{
	header("Location: ../views/ccart.php");
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

	if(isset($_SESSION['cart'][$id]))
	{
		if($_SESSION['cart'][$id]['qty'] > 1)
		{
			$_SESSION['cart'][$id]['qty'] = $_SESSION['cart'][$id]['qty'] - 1;
		}
		else
		{
			unset($_SESSION['cart'][$id]);
		}
	}

	header("Location: ../controllers/ccartController.php?action=view");
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

	if(isset($_SESSION['cart'][$id]))
	{
		$_SESSION['cart'][$id]['qty'] = $qty;
	}

	header("Location: ../controllers/ccartController.php?action=view");
	exit();
}

mysqli_close($conn);
exit();
?>