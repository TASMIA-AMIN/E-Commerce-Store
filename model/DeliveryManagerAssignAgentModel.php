<?php
function assignDelivery($conn, $orderId, $agentId){

    $sql = "INSERT INTO delivery_assignments(order_id, agent_id, assigned_at, status) VALUES('$orderId', '$agentId', NOW(), 'assigned')";
    
    mysqli_query($conn, $sql);
}

function updateOrderZone($conn, $orderId, $zoneId){

    $sql = "UPDATE orders SET zone_id = '$zoneId' WHERE id = '$orderId'";

    mysqli_query($conn, $sql);
}

?>