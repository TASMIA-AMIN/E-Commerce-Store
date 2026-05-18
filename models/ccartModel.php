<?php

session_start();

function addToCart($product)
{
	if(!isset($_SESSION['cart']))
	{
		$_SESSION['cart'] = [];
	}
	$id = $product['id'];

	if(isset($_SESSION['cart'][$id]))
	{
		$_SESSION['cart'][$id]['qty'] += 1;
	}

	else
	{
		$_SESSION['cart'][$id] = ['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price'], 'qty' => 1];
	}
}


function removeFromCart($id)
{
	if(isset($_SESSION['cart'][$id]))
	{
		unset($_SESSION['cart'][$id]);
	}
}


function getCart()
{
	if(!isset($_SESSION['cart']))
	{
		return [];
	}
	return $_SESSION['cart'];
}


function updateCart($id, $qty)
{
	if(isset($_SESSION['cart'][$id]))
	{
		if($qty > 0)
		{
			$_SESSION['cart'][$id]['qty'] = $qty;
		}
		else
		{
			unset($_SESSION['cart'][$id]);
		}
	}
}

function cartTotal()
{
	$total = 0;
	if(isset($_SESSION['cart']))
	{
		foreach($_SESSION['cart'] as $c)
		{
			$total += $c['price'] * $c['qty'];
		}
	}
	return $total;
}


?>