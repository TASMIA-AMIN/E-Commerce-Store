<?php

session_start();
if(!isset($_SESSION['user_name']))
{
	header("Location: clogin.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Dashboard</title>
</head>
<body>
	<h2>Customer Dashboard</h2>
	<p> Welcome <?php echo $_SESSION['user_name']; ?> !</p>
	<ul>
		<li><a href="../controllers/cproductController.php">Browse Products</a></li>
		<li><a href="../controllers/ccartController.php?action=view"">Cart</a></li>
		<li><a href="wishlist.php">Wishlist</a></li>
		<li><a href="orders.php">Orders</a></li>
		<li><a href="clogout.php">Logout</a></li>
	</ul>
</body>
</html>
