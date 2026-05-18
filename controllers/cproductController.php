<?php
session_start();

require_once "../config/connect.php";
require_once "../models/cproductModel.php";

$conn = connect();

$action = $_GET['action'] ?? '';

/* DETAILS */
if($action == "details")
{
	$product_id = $_GET['id'];

	$sql = "SELECT * FROM products WHERE id='$product_id'";
	$result = mysqli_query($conn, $sql);

	if(!$result)
	{
		die("Query error");
	}

	$product = mysqli_fetch_assoc($result);

	if(!$product)
	{
		die("Product not found");
	}

	require "../views/cproductDetail.php";
	exit();
}

/* LIST */
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$products = [];

while($row = mysqli_fetch_assoc($result))
{
	$products[] = $row;
}

$keyword = '';
if(isset($_GET['keyword']))
{
	$keyword = $_GET['keyword'];
}

$category_id = 0;
if(isset($_GET['category_id']))
{
	$category_id = $_GET['category_id'];
}

$min_price = 0;
if(isset($_GET['min_price']))
{
	$min_price = $_GET['min_price'];
}

$max_price = 0;
if(isset($_GET['max_price']))
{
	$max_price = $_GET['max_price'];
}

$availability = 0;
if(isset($_GET['availability']))
{
	$availability = $_GET['availability'];
}

$sql = "SELECT * FROM products WHERE 1=1";

if($keyword != '')
{
	$sql .= " AND name LIKE '%$keyword%'";
}

if($category_id > 0)
{
	$sql .= " AND category_id='$category_id'";
}

if($min_price > 0)
{
	$sql .= " AND price >= '$min_price'";
}

if($max_price > 0)
{
	$sql .= " AND price <= '$max_price'";
}

if($availability == 1)
{
	$sql .= " AND stock_qty > 0";
}

$result = mysqli_query($conn, $sql);

$products = array();

while($row = mysqli_fetch_assoc($result))
{
	$products[] = $row;
}

$categories = getMainCategories($conn);
$subcategories = getSubCategories($conn);
require "../views/cproducts.php";
?>