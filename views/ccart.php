<?php
session_start();

if(!isset($_SESSION['user_name']))
{
	header("Location: ../views/clogin.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
</head>
<body>

<h2>Cart</h2>

<table border="1">
<tr>
	<th>Name</th>
	<th>Price</th>
	<th>Quantity</th>
	<th>Action</th>
</tr>

<?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>

	<?php foreach($_SESSION['cart'] as $index => $c): ?>

	<tr>
		<td><?php echo $c['name']; ?></td>
		<td><?php echo $c['price']; ?></td>
		<td><?php echo $c['qty']; ?></td>

		<td>
			<a href="../controllers/ccartController.php?action=remove&id=<?php echo $index; ?>">
				Remove
			</a>
		</td>
	</tr>

	<?php endforeach; ?>

<?php else: ?>

	<tr>
		<td colspan="4">Cart is empty</td>
	</tr>

<?php endif; ?>

</table>

<br>

<a href="../controllers/corderController.php?action=checkout">
	Proceed to Checkout
</a>

<br><br>

<a href="../views/cdashboard.php">
	Back to Dashboard
</a>

</body>
</html>