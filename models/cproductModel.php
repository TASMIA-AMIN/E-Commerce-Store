<?php

function getAllProducts($conn)
{
	$sql = "SELECT * FROM products";
	$result = mysqli_query($conn, $sql);

	$products = array();

	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$products [] = $row;
		}
	}
	return $products;
}

?>