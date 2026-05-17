<?php
session_start();

if(!isset($_SESSION['user_name']))
{
	header("Location: clogin.php");
	exit();
}

if(!empty($_SESSION['cart_data']))
 {
 	$cart_data = $_SESSION['cart_data'];
 }
 else
 {
 	$cart_data = array();
 }

 unset($_SESSION['cart_data']);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
</head>
<body>
	<h2>Cart</h2>
	<p> Welcome <?php echo $_SESSION['user_name']; ?> !</p>

	<ul>
		<li><a href="cdashboard.php">Dashboard</a></li>
		<li><a href="../controllers/cproductController.php">Products</a></li>
		<li><a href="../controllers/ccartController.php?action=view">Cart</a></li>
		<li><a href="wishlist.php">Wishlist</a></li>
		<li><a href="orders.php">Orders</a></li>
		<li><a href="clogout.php">Logout</a></li>
	</ul>

	<table border="1">
		<tr>
	        <th>Name</th>
	        <th>Price</th>
	        <th>Quantity</th>
	        <th>Action</th>
        </tr>
	
	<hr>
	<?php foreach($cart_data as $index =>$c): ?>
		<tr>
		<td><?php echo $c['name']; ?></td>
		<td><?php echo $c['price']; ?></td>
		<td><?php echo $c['qty']; ?></td>
		<td>
			<a href="../controllers/ccartController.php?action=remove&index=<?php echo $index; ?>">
				Remove
			</a>
		</td>
	</tr>
     <?php endforeach; ?>	
	</table>
</body>
</html>
