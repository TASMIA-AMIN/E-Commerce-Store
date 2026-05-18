<?php

function createUser($conn, $name, $email, $phone, $password)
{
	$sql = "INSERT INTO users (name, email, phone, password_hash, role)
	        VALUES ('$name', '$email', '$phone', '$password', 'customer')";

	return mysqli_query($conn, $sql);        
}


function loginUser($conn, $email, $password)
{
	$sql = "SELECT * FROM users
	        WHERE email = '$email'
	        AND password_hash = '$password'
	        AND role = 'customer'
	        LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)==1)
	{
		return mysqli_fetch_assoc($result);
	}
	return null;
}


?>

