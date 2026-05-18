<?php
	require_once '../model/DeliveryManagerGeneric.php';
	require_once '../model/DeliveryManagerEditZoneModel.php';
	if($_POST['action'] == "deleteZone"){

	    $id = $_POST['id'];

	    $conn = Connect();
	    deleteZone($conn, $id);
	    Close($conn);

	    echo json_encode(["status" => "success", "message" => "Zone Deleted Successfully!!!"]);
	}
	if($_POST['action'] == "updateZone"){

	    $id = $_POST['id'];
	    $name = $_POST['name'];
	    $fee = $_POST['fee'];
	    $days = $_POST['days'];

	    $conn = Connect();

	    if(nameExists($conn, $id, $name)){
	        echo json_encode(["status" => "error", "message" => "Name Already Exists!"]);
	        Close($conn);
	    }
	    else if(empty($name)){
		    echo json_encode(["status" => "error","message" => "Zone name cannot be empty!"]);
		    Close($conn);
		}

		else if(empty($days) || !ctype_digit($days) || $days <= 0){
		    echo json_encode(["status" => "error","message" => "Estimated days must be a positive integer!"]);
		    Close($conn);
		}

		else if(empty($fee) || !is_numeric($fee) || $fee < 0){
		    echo json_encode(["status" => "error","message" => "Delivery fee must be a valid number!"
		    ]);
		    Close($conn);
		}
	    else{
	        updateZone($conn, $id, $name, $fee, $days);

	        echo json_encode(["status" => "success", "message" => "Successfully Updated!"]);
	        
		}
	    
	}

?>