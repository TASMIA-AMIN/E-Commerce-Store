<?php

	session_start();
	require_once '../model/DeliveryManagerLoginModel.php';
	require_once '../model/DeliveryManagerGeneric.php';

	$userPhoneErr = "";
	$userPassErr = "";

	$method = $_SERVER['REQUEST_METHOD'];
	if($method == "POST"){

		$userPhone = $_POST['userPhone'];
		$userPass = $_POST['userPass'];

		$hasError = false;

		if($userPhone == ""){
			$userPhoneErr = "Please Fill Up the Phone Number Field!!!";
			$hasError = true;
		}
		else{
			$userPhoneErr = "";
			
		}
		if($userPass == ""){
			$userPassErr = "Please Fill Up the Password Field!!!";
			$hasError = true;
		}
		else{
			$userPassErr = "";
			
		}

		if(!$hasError){
			$conn = Connect();
			$isMatched = checkValidity($userPhone, $userPass, $conn);
			

			if($isMatched){
				$_SESSION['isLogged'] = true;
				$_SESSION['username'] = getUserName($conn, $userPhone);
				$_SESSION['userid'] = getUserId($conn, $userPhone);
				
				header('Location: ../controller/DeliveryManagerDashboardController.php');
				Close($conn);
				exit();

			}
			else{
				$_SESSION['loginMsg'] = "Wrong Credentials! Please Try Again!";
				header('Location: ../controller/DeliveryManagerLoginController.php');
				Close($conn);
				exit();
			}

		}
		
	}
	include '../views/DeliveryManagerLogin.php';

?>