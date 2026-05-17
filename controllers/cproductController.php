<?php

session_start();

require_once "../config/connect.php";
require_once "../models/cproductModel.php";

$conn = connect();
if($conn)
{
	$products = getAllProducts($conn);
}
else
{
	$products = array();
}
mysqli_close($conn);


$_SESSION['products'] = $products;

header("Location: ../views/cproducts.php");
exit();

?>