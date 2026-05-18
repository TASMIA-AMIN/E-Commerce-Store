<?php
session_start();

if(!isset($_SESSION['user_name']))
{
	header("Location:clogin.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Order Details</title>
</head>
<body>
	<h2>Order Details</h2>
	<?php if (!empty($order)): ?>

		<p><b>Order ID: </b> <?php echo $order['id']; ?></p>
		<p><b>Address: </b> <?php echo $order['address']; ?></p>
		<p><b>Delivery Zone: </b> <?php echo $order['delivery_zone']; ?></p>
		<p><b>Payment Method: </b> <?php echo $order['payment_method']; ?></p>

		<hr>
		<h3>Items</h3>
		<table border ="1">
		<tr>
			<th>Product ID</th>
			<th>Name</th>
			<th>Price</th>
			<th>QTY</th>
		</tr>

		<?php foreach($items as $i): ?>
			<tr>
				<td><?php echo $i['product_id']; ?></td>
				<td><?php echo $i['product_name']; ?></td>
				<td><?php echo $i['price']; ?></td>
				<td><?php echo $i['qty']; ?></td>
			</tr>
		<?php endforeach; ?>

	    </table>

	<?php else: ?>
		<p> Order not found </p>
	<?php endif; ?>

	<br><br>

    <a href="../controllers/corderController.php?action=list">Back to Orders</a>

</body>
</html>




	

