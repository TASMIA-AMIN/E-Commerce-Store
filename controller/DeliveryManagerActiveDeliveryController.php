<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerActiveDeliveryModel.php';

$conn = Connect();
$assignments = getAllActiveAssignments($conn);
Close($conn);

include '../views/DeliveryManagerActiveDelivery.php';

?>