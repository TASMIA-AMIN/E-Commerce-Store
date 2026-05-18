<!DOCTYPE html>
<html>
<head>
	<title>Order Details</title>
</head>
<body>

<h2>Order Details</h2>

<p><b>Order ID:</b> <?php echo $order['id']; ?></p>

<p><b>Shipping Address:</b> <?php echo $order['shipping_address']; ?></p>

<p><b>Payment Method:</b> <?php echo $order['payment_method']; ?></p>

<p><b>Status:</b> <?php echo $order['status']; ?></p>

<hr>

<h3>Items</h3>

<table border="1">
	<tr>
		<th>Product ID</th>
		<th>Name</th>
		<th>Price</th>
		<th>Qty</th>
	</tr>

	<?php foreach($items as $i): ?>

	<?php
	$product_id = $i['product_id'];

	$sql = "SELECT name, price FROM products WHERE id='$product_id'";
	$result = mysqli_query($conn, $sql);
	$product = mysqli_fetch_assoc($result);
	?>

	<tr>
		<td><?php echo $product_id; ?></td>
		<td><?php echo $product['name']; ?></td>
		<td><?php echo $product['price']; ?></td>
		<td><?php echo $i['quantity']; ?></td>
	</tr>

	<?php endforeach; ?>

</table>

<br>

<a href="../controllers/corderController.php?action=list">Back to Orders</a>

</body>
</html>