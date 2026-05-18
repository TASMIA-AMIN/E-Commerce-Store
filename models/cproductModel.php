<?php

function getAllProducts($conn)
{
	$sql = "SELECT * FROM products WHERE is_available=1";
	$result = mysqli_query($conn, $sql);

    if(!$result)
    {
        return [];
    }

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