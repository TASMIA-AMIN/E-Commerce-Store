<?php

function createOrder($conn, $customer_id, $address, $payment, $subtotal, $total)
{
	$sql = "INSERT INTO orders (customer_id, shipping_address, payment_method, subtotal, total_amount, status)
	        VALUES ('$customer_id', '$address', '$payment', '$subtotal', '$total', 'pending')";
	mysqli_query($conn, $sql);

	return mysqli_insert_id($conn);
}

function createOrderItem($conn, $order_id, $product_id, $seller_id, $qty, $price)
{
	$sql = "INSERT INTO order_items (order_id, product_id, seller_id, quantity, unit_price)
	        VALUES ('$order_id', '$product_id', '$seller_id', '$qty', '$price')";
	mysqli_query($conn, $sql);
}

?>
