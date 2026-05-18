<?php

function getAllProducts($conn)
{
	$sql = "SELECT * FROM products";
	$result = mysqli_query($conn, $sql);

	$products = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$products[] = $row;
	}

	return $products;
}

function getProductsByCategory($conn, $category_id)
{
	$sql = "SELECT * FROM products WHERE category_id='$category_id'";
	$result = mysqli_query($conn, $sql);

	$products = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$products[] = $row;
	}

	return $products;
}

function getMainCategories($conn)
{
	$sql = "SELECT * FROM categories WHERE parent_id IS NULL";
	$result = mysqli_query($conn, $sql);

	$categories = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$categories[] = $row;
	}

	return $categories;
}

function getSubCategories($conn)
{
	$sql = "SELECT * FROM categories WHERE parent_id IS NOT NULL";
	$result = mysqli_query($conn, $sql);

	$subcategories = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$subcategories[] = $row;
	}

	return $subcategories;
}

?>