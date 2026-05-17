<?php
session_start();

if(!isset($_SESSION['user_name']))
{
	header("Location: clogin.php");
	exit();
}
 if(!empty($_SESSION['products']))
 {
 	$products = $_SESSION['products'];
 }
 else
 {
 	$products = array();
 }

 unset($_SESSION['products']);
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
		<li><a href="cdashboard.php">Dashboard</a></li>
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
	
	<?php foreach($products as $p): ?>
		<tr>
		<td><?php echo $p['id']; ?></td>
		<td><?php echo $p['name']; ?></td>
		<td><?php echo $p['price']; ?></td>
		<td><?php echo $p['stock_qty']; ?></td>
		<td>
			<a href="../controllers/ccartController.php?action=add&id=<?php echo $p['id']; ?>&name=<?php echo $p['name']; ?>&price=<?php echo $p['price']; ?>">
				Add to Cart
			</a>
		</td>
	</tr>
		<?php endforeach; ?>	
	</table>
</body>
</html>
