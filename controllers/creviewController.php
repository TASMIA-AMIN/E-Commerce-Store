<?php
session_start();

require_once "../config/connect.php";
require_once "../models/creviewModel.php";

$conn = connect();

$action = '';

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}

if($action == "add")
{
	$product_id = $_POST['product_id'];
	$order_id = $_POST['order_id'];
	$customer_id = $_SESSION['user_id'];
	$rating = $_POST['rating'];
	$review_text = $_POST['review_text'];

	addReview($conn, $product_id, $order_id, $customer_id, $rating, $review_text);

	header("Location: ../controllers/cproductController.php?action=details&id=$product_id");
	exit();
}

mysqli_close($conn);
?>