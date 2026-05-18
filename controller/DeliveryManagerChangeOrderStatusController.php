<?php
	require_once '../model/DeliveryManagerGeneric.php';
	require_once '../model/DeliveryManagerChangeOrderStatusModel.php';
	if($_POST['action'] == "changeStatus"){

    $id = $_POST['id'];
    $status = $_POST['status'];

    $conn = Connect();

    if(empty($status)){

        echo json_encode([
            "status" => "error",
            "message" => "Please select status!"
        ]);
    }
    else{

        changeStatus($conn, $id, $status);

        echo json_encode([
            "status" => "success",
            "message" => "Status Changed successfully!"
        ]);
    }

    Close($conn);
}

?>