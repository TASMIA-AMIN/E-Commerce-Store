<?php
session_start();
$products = 
[
	[
		"id" => 1,
		"name" => "Smartphone",
		"price" => 15000,
		"description" => "Latest android phone"
	],
	[ 
	    "id" => 2,
		"name" => "Laptop",
		"price" => 50000,
		"description" => "High performance laptop"
    ],
    [
    	"id" => 3,
		"name" => "Headphones",
		"price" => 2000,
		"description" => "Wireless headphone"
    ]

];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
</head>
<body>
	<h2>Products</h2>
	<ul>
		<li><a href="dashboard.php">Dashboard</a></li>
		<li><a href="cart.php">Cart</a></li>
		<li><a href="wishlist.php">Wishlist</a></li>
		<li><a href="orders.php">Orders</a></li>
		<li><a href="logout.php">Logout</a></li>
	</ul>
	<hr>
	<?php foreach ($products as $p) { ?>
		<div>
			<h3><?php echo $p['name'];?></h3>
			<p><?php echo $p['description'];?></p>
			<p><b>Price</b><?php echo $p['price'];?>BDT</p>
			<a href="cart.php"> Add to cart </a>
		<hr>
	</div>
	<?php } ?>
</body>
</html>
