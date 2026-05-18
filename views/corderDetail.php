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

	<tr>
		<td colspan="4">

			<h3>Write Review</h3>

			<form method="POST" action="../controllers/creviewController.php?action=add">

				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
				<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">

				<label>Rating (1-5): min="1" max="5"</label>
				<input type="number" name="rating" >
				<br><br>

				<label>Review:</label>
				<textarea name="review_text"></textarea>
				<br><br>

				<button type="submit">Submit Review</button>

			</form>

		</td>
	</tr>

	<?php endforeach; ?>

</table>

<br>

<a href="../controllers/corderController.php?action=list">Back to Orders</a>

</body>
</html>