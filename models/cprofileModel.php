<?php

function getUserById($conn, $user_id)
{
	$sql = "SELECT * FROM users WHERE id='$user_id' LIMIT 1";
	$result = mysqli_query($conn, $sql);
	return mysqli_fetch_assoc($result);
}

function updateProfile($conn, $user_id, $name, $email, $phone, $profile_pic)
{
	$sql = "UPDATE users SET name='$name', email= '$email', phone= '$phone', profile_pic= '$profile_pic' WHERE id='$user_id'";
	$result = mysqli_query($conn, $sql);
}

function updatePassword($conn, $user_id, $new_password)
{
	$sql = "UPDATE users SET password_hash='$new_password' WHERE id='$user_id'";
	$result = mysqli_query($conn, $sql);
}

?>