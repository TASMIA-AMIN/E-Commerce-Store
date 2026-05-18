<?php
function createOrder($conn, $user_id, $address, $delivery_zone, $payment_method, $subtotal, $total)
{
	$sql1 = "INSERT INTO orders (user_id, address, delivery_zone, payment_method, subtotal, total)
	        VALUES ('$user_id', '$address', '$delivery_zone', '$payment_method', '$subtotal', '$total')";

	mysqli_query($conn, $sql1);

	$sql2 = "SELECT id FROM orders WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($conn, $sql2);
	$row = mysqli_fetch_assoc($result);

	return $row['id'];
}

function saveOrderItems($conn, $order_id, $cart)
{
	foreach($cart as $c)
	{
		$product_id = $c['id'];
		$product_name = $c['name'];
		$price = $c['price'];
		$qty = $c['qty'];

		$sql = "INSERT INTO order_items(order_id, product_id, product_name, price, qty)
		        VALUES('$order_id', '$product_id', '$product_name', '$price', '$qty')";

		mysqli_query($conn, $sql);
	}
}

?>