<?php
	function Connect(){
		$host = "localhost";
		$dbuser = "root";
		$dbpass = "";
		$dbname = "ecommerce";

		$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

		if(!$conn){
			die("Connection Error" . mysqli_connect_error($conn));
		}

		return $conn;
	}

	function Close($conn){
		mysqli_close($conn);
	}

?>