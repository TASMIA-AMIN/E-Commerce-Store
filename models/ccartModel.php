<?php


function addToCart($id, $name, $price)
{
	if(!isset($_SESSION['cart']))
	{
		$_SESSION['cart'] = array();
	}

	$_SESSION['cart'][] = array("id"=> $id, "name"=> $name, "price"=> $price, "qty"=> 1);
}

function getCart()
{
	if(isset($_SESSION['cart']))
	{
		return $_SESSION['cart'];
	}
	return array();
}

function removeFromCart($index)
{
	if(isset($_SESSION['cart'][$index]))
	{
		unset($_SESSION['cart'][$index]);
		$_SESSION['cart'] = array_values($_SESSION['cart']);
	}
}

?>