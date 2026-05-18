<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerDeliveryHistoryModel.php';

$conn = Connect();
$deliveries = getAllDeliveries($conn);
Close($conn);

include '../views/DeliveryManagerDeliveryHistory.php';

?>