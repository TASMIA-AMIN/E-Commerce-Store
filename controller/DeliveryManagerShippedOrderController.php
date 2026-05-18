<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerShippedOrderModel.php';

$conn = Connect();
$zones = getAllZone($conn);
$orders = getAssigningOrders($conn);
$agents = getFreeAgents($conn);
Close($conn);

include '../views/DeliveryManagerShippedOrder.php';

?>