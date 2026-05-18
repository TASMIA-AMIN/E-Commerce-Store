<?php

function addReview($conn, $product_id, $order_id, $customer_id, $rating, $review_text)
{
	$sql = "INSERT INTO reviews (product_id, order_id, customer_id, rating, review_text, created_at)
            VALUES ('$product_id', '$order_id', '$customer_id', '$rating', '$review_text', '$created_at')";
	mysqli_query($conn, $sql);
}

function getReviewsByProduct($conn, $product_id)
{
	$sql = "SELECT * FROM reviews WHERE product_id='$product_id' ORDER BY id DESC";
	$result = mysqli_query($conn, $sql);

	$reviews = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$reviews[] = $row;
	}

	return $reviews;
}

?>