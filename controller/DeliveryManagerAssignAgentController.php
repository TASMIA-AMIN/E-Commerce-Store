<?php
	require_once '../model/DeliveryManagerGeneric.php';
	require_once '../model/DeliveryManagerAssignAgentModel.php';
	if($_POST['action'] == "assignAgent"){

    $orderId = $_POST['orderId'];
    $zoneId = $_POST['zoneId'];
    $agentId = $_POST['agentId'];

    $conn = Connect();

    if(empty($zoneId) || empty($agentId)){

        echo json_encode([
            "status" => "error",
            "message" => "Please select zone and agent!"
        ]);
    }
    else{

        assignDelivery($conn, $orderId, $agentId);

        updateOrderZone($conn, $orderId, $zoneId);

        echo json_encode([
            "status" => "success",
            "message" => "Agent assigned successfully!"
        ]);
    }

    Close($conn);
}

?>