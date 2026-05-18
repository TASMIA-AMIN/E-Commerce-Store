<?php
	session_start();
	require_once '../model/DeliveryManagerNewZoneModel.php';
	require_once '../model/DeliveryManagerGeneric.php';

	$zoneNameErr = "";
	$zoneDelFeeErr = "";
	$zoneEstDaysErr = "";
	$dupMsg = "";
	$hasError = false;


	$method = $_SERVER['REQUEST_METHOD'];
	if($method == "POST"){

		$zoneName = $_POST['zName'];
		$zoneDelFee = $_POST['zDelFee'];
		$zoneEstDays = $_POST['zEstDays'];

		

		if($zoneName == ""){
			$zoneNameErr = "Please Fill Up the Name Field!!!";
			$hasError = true;
		}
		else if(strlen($zoneName) < 4){
			$zoneNameErr = "Name must have minimum 6 characters!!!";
			$hasError = true;
		}
		else{
			$zoneNameErr = "";
		}
		if($zoneDelFee == ""){
			$zoneDelFeeErr = "Please Fill Up the Fee Field!!!";
			$hasError = true;
		}
		else if(!is_numeric($zoneDelFee) || $zoneDelFee<0){
			$zoneDelFeeErr = "Please Enter a Number as Fee!!!";
			$hasError = true;
		}
		else{
			$zoneDelFeeErr = "";
		}
		if($zoneEstDays == ""){
			$zoneEstDaysErr = "Please Fill Up the Estimated Day Field!!!";
			$hasError = true;
		}
		else if(!ctype_digit($zoneEstDays) || $zoneEstDays<0){
			$zoneEstDaysErr = "Please Enter an Integer Number as Fee!!!";
			$hasError = true;
		}
		else{
			$zoneEstDaysErr = "";
		}

		if(!$hasError){
			$conn = Connect();
			$hasDuplicate = checkDuplicate($conn, $zoneName);
			
			if($hasDuplicate)
			{
				$dupMsg = "There is already a zone with same name!!!";
				Close($conn);
			}
			else{
				addZone($conn, $zoneName, $zoneDelFee, $zoneEstDays);
				header('Location: ../controller/DeliveryManagerManageZoneController.php');

			}
			
		}
		
	}
	include '../views/DeliveryManagerNewZone.php';


?>