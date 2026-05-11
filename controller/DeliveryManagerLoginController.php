<?php

	session_start();
	require_once '../model/DeliveryManagerLoginModel.php';
	require_once '../model/DeliveryManagerGeneric.php';

	$method = $_SERVER['REQUEST_METHOD'];
	if($method == "POST"){

		$userPhone = $_POST['userPhone'];
		$userPass = $_POST['userPass'];

		$conn = Connect();
		$isMatched = checkValidity($userPhone, $userPass, $conn);
		

		if($isMatched){
			$_SESSION['isLogged'] = true;
			$_SESSION['username'] = getUserName($conn, $userPhone);
			
			header('Location: ../views/DeliveryManagerDashboard.php');
			Close($conn);
			exit();

		}
		else{
			$_SESSION['loginMsg'] = "Wrong Credentials! Please Try Again!";
			header('Location: ../views/DeliveryManagerLogin.php');
			Close($conn);
			exit();
		}


	}

?>