<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
</head>
<body>

<h2>Products</h2>
<form method="GET" action="../controllers/cproductController.php">

	<label>Search:</label>
	<input type="text" name="keyword"><br><br>

	<label>Min Price:</label>
	<input type="number" name="min_price"><br><br>

	<label>Max Price:</label>
	<input type="number" name="max_price"><br><br>

	<label><input type="checkbox" name="availability" value="1">In Stock Only</label><br><br>

	<button type="submit">Search</button>

</form>

<hr>

<h3>Categories</h3>

<a href="../controllers/cproductController.php">All Products</a>
<br><br>

<?php foreach($categories as $c): ?>

	<b><a href="../controllers/cproductController.php?category_id=<?php echo $c['id']; ?>"><?php echo $c['name']; ?></a></b>
	<br>

	<?php foreach($subcategories as $s): ?>
		<?php if($s['parent_id'] == $c['id']): ?>

			-<a href="../controllers/cproductController.php?category_id=<?php echo $s['id']; ?>">
				<?php echo $s['name']; ?>
			</a>
			<br>

		<?php endif; ?>
	<?php endforeach; ?>

	<br>

<?php endforeach; ?>

<hr>
<table border="1">

	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Price</th>
		<th>Stock</th>
		<th>Action</th>
	</tr>

	<?php if(!empty($products)): ?>
		<?php foreach($products as $p): ?>

			<tr>
				<td><?php echo $p['id']; ?></td>
				<td><?php echo $p['name']; ?></td>
				<td><?php echo $p['price']; ?></td>
				<td><?php echo $p['stock_qty']; ?></td>
				<td>
					<a href="../controllers/cproductController.php?action=details&id=<?php echo $p['id']; ?>">View Details</a>
					<br>
					<a href="../controllers/ccartController.php?action=add&product_id=<?php echo $p['id']; ?>">
						Add to Cart
					</a>
					<br>
					<a href="../controllers/cwishlistController.php?action=add&product_id=<?php echo $p['id']; ?>">Add to Wishlist</a>
				</td>

			</tr>

		<?php endforeach; ?>
	<?php else: ?>

		<tr>
			<td colspan="5">No products found</td>
		</tr>

	<?php endif; ?>
</table>
<br><br>

<a href="../views/cdashboard.php"> Back to Dashboard </a>

</body>
</html>