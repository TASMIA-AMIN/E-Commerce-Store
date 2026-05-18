<!DOCTYPE html>
<html>
<head>
	<title>My Orders</title>
</head>
<body>

	<h2>My Orders</h2>
	<p>Welcome <?php echo $_SESSION['user_name']; ?> !</p>

	<table border="1">
		<tr>
			<th>Order Id</th>
			<th>Shipping Address</th>
			<th>Total Amount</th>
			<th>Payment</th>
			<th>Status</th>
			<th>Action</th>
		</tr>

		<?php if(!empty($orders)): ?>
			<?php foreach($orders as $o): ?>
				<tr>
					<td><?php echo $o['id']; ?></td>
					<td><?php echo $o['shipping_address']; ?></td>
					<td><?php echo $o['total_amount']; ?></td>
					<td><?php echo $o['payment_method']; ?></td>
					<td><?php echo $o['status']; ?></td>
					<td>
						<a href="../controllers/corderController.php?action=details&id=<?php echo $o['id']; ?>">
							View Details
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="6">No orders found</td>
			</tr>
		<?php endif; ?>

	</table>

	<br>
	<a href="../views/cdashboard.php">Back to Dashboard</a>

</body>
</html>