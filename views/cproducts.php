<?php


if(!isset($_SESSION['user_name']))
{
	header("Location: clogin.php");
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Browse Products</title>
</head>
<body>
	<h2>Products</h2>
	<p> Welcome <?php echo $_SESSION['user_name']; ?> !</p>

	<ul>
		<li><a href="../views/cdashboard.php">Dashboard</a></li>
		<li><a href="../controllers/ccartController.php?action=view">Cart</a></li>
		<li><a href="wishlist.php">Wishlist</a></li>
		<li><a href="orders.php">Orders</a></li>
		<li><a href="clogout.php">Logout</a></li>
	</ul>

	<table border="1">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Price</th>
			<th>Stock</th>
			<th>Action</th>
		</tr>
	

<?php

if(!empty($products))
{
	foreach($products as $p)
	{
		print "
		<tr>
			<td>".$p['id']."</td>
			<td>".htmlspecialchars($p['name'])."</td>
			<td>".$p['price']."</td>
			<td>".$p['stock_qty']."</td>
			<td>
				<a href='../controllers/ccartController.php?action=add&id=".$p['id']."'>
					Add to Cart
				</a>
			</td>
		</tr>
		";
	}
}
else
{
	print "
	<tr>
		<td colspan='5'>No products available</td>
	</tr>
	";
}

?>
    </table>
</body>
</html>
