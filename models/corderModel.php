<?php

function createOrder($conn, $user_id, $address, $delivery_zone, $payment_method, $subtotal, $total)
{
	$sql1 = "INSERT INTO orders
	(customer_id, shipping_address, payment_method, subtotal, total_amount, status, created_at)

	VALUES
	('$user_id', '$address', '$payment_method', '$subtotal', '$total', 'pending', NOW())";

	$result = mysqli_query($conn, $sql1);

	if(!$result)
	{
		die("Order Insert Failed: " . mysqli_error($conn));
	}

	return mysqli_insert_id($conn);
}


function saveOrderItems($conn, $order_id, $cart)
{
	foreach($cart as $c)
	{
		$product_id = $c['id'];
		$quantity = $c['qty'];

		$sqlSeller = "SELECT seller_id FROM products WHERE id='$product_id'";
		$resultSeller = mysqli_query($conn, $sqlSeller);

		$rowSeller = mysqli_fetch_assoc($resultSeller);

		$seller_id = $rowSeller['seller_id'];

		$sql = "INSERT INTO order_items
		(order_id, product_id, seller_id, quantity)

		VALUES
		('$order_id', '$product_id', '$seller_id', '$quantity')";

		$result = mysqli_query($conn, $sql);

		if(!$result)
		{
			die("Order Item Insert Failed: " . mysqli_error($conn));
		}
	}
}

?>