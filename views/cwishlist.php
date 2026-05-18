<!DOCTYPE html>
<html>
<head>
	<title>My Wishlist</title>
</head>
<body>
	<h2>My Wishlist</h2>
	
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Product</th>
			<th>Price</th>
			<th>Action</th>
		</tr>
		<?php if(!empty($wishlist)): ?>
			<?php foreach($wishlist as $w): ?>
				<tr>
					<td><?php echo $w['id'];?></td>
					<td><?php echo $w['name'];?></td>
					<td><?php echo $w['price'];?></td>
					<td><a href="../controllers/cwishlistController.php?action=remove&id=<?php echo $w['wishlist_id']; ?>">Remove</a></td>
				</tr>

			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="4">Wishlist is empty</td>
			</tr>

		<?php endif; ?>
	</table>
	<br>
	<a href="../views/cdashboard.php"> Back to Dashboard </a>
</body>
</html>



