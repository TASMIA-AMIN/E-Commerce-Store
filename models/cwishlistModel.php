<?php

function addWishlist($conn, $customer_id, $product_id)
{
	$sql = "INSERT INTO wishlists(customer_id, product_id)
	        VALUES('$customer_id', '$product_id')";
	return mysqli_query($conn, $sql);
}

function removeWishlist($conn, $wishlist_id, $customer_id)
{
	$sql = "DELETE FROM wishlists WHERE id='$wishlist_id' AND customer_id='$customer_id'";
	return mysqli_query($conn, $sql);
}

function getWishlist($conn, $customer_id)
{
	$sql1 = "SELECT * FROM wishlists WHERE customer_id='$customer_id'";
	$result1 = mysqli_query($conn, $sql1);
	$wishlist = array();

	while($w = mysqli_fetch_assoc($result1))
	{
		$product_id = $w['product_id'];

		$sql2 = "SELECT * FROM products WHERE id='$product_id'";
		$result2 = mysqli_query($conn, $sql2);
        $product = mysqli_fetch_assoc($result2);
		$product['wishlist_id'] = $w['id'];
		$wishlist[] = $product;
	}
	return $wishlist;
}

?>