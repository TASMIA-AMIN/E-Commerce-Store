<?php
	session_start();
	require_once '../model/DeliveryManagerNewAgentModel.php';
	require_once '../model/DeliveryManagerGeneric.php';

	$agentNameErr = "";
	$agentPhoneErr = "";
	$dupMsg = "";
	$hasError = false;


	$method = $_SERVER['REQUEST_METHOD'];
	if($method == "POST"){

		$agentName = $_POST['aName'];
		$agentPhone = $_POST['aPhone'];
		$agentVehicle = $_POST['aVehicleType'];

		

		if($agentName == ""){
			$agentNameErr = "Please Fill Up the Name Field!!!";
			$hasError = true;
		}
		else if(strlen($agentName) < 4){
			$agentNameErr = "Name must have minimum 4 characters!!!";
			$hasError = true;
		}
		else{
			$agentNameErr = "";
		}
		if($agentPhone == ""){
			$agentPhoneErr = "Please Fill Up the Phone Number Field!!!";
			$hasError = true;
		}
		else if(!preg_match("/^01[0-9]{9}$/", $agentPhone)){
			$agentPhoneErr = "Please Enter a Valid Phone Number!!!";
			$hasError = true;
		}
		else{
			$agentPhoneErr = "";
		}

		if(!$hasError){
			$conn = Connect();
			$hasDuplicate = checkDuplicate($conn, $agentPhone);
			
			if($hasDuplicate)
			{
				$dupMsg = "There is already an agent with the same phone number!!!";
				Close($conn);
			}
			else{
				addAgent($conn, $_SESSION['userid'], $agentName, $agentPhone, $agentVehicle);
				header('Location: ../controller/DeliveryManagerManageAgentController.php');

			}
			
		}
		
	}
	include '../views/DeliveryManagerNewAgent.php';


?>