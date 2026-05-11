<?php
	function checkValidity($userPhone, $userPass, $conn){
		$sql = "SELECT id, password_hash FROM users WHERE phone = '$userPhone' AND role = 'delivery_manager'";

		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_assoc($result);

			if(password_verify($userPass, $row['password_hash'])){
				return true;
			}
		}
		return false;
	}

	function getUserName($conn, $userPhone){

	$sql = "SELECT name FROM users WHERE phone = '$userPhone'";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		return $row['name'];
	}

	return null;
}