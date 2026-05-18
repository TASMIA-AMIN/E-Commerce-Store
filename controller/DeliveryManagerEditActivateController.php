<?php
	require_once '../model/DeliveryManagerGeneric.php';
	require_once '../model/DeliveryManagerEditActivateModel.php';
	if($_POST['action'] == "toggleStatus"){
		$id = $_POST['id'];

		$conn = Connect();
		$currentStatus = getCurrentStatus($conn, $id);
		

		$newStatus = ($currentStatus == 0) ? 1 : 0;
		updateStatus($conn, $newStatus, $id);
		Close($conn);

		echo $newStatus;
	}
	if($_POST['action'] == "updateAgent"){

	    $id = $_POST['id'];
	    $name = $_POST['name'];
	    $phone = $_POST['phone'];
	    $vehicle = $_POST['vehicle'];

	    $conn = Connect();

	    if(phoneExists($conn, $id, $phone)){
	        echo json_encode(["status" => "error", "message" => "Phone Number Already Exists!"]);
	        Close($conn);
	    }
	    else{
	        updateAgent($conn, $id, $name, $phone, $vehicle);

	        echo json_encode(["status" => "success", "message" => "Successfully Updated!"]);
	        
		}
	    
	}

?>