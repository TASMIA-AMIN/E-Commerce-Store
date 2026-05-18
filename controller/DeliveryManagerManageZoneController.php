<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerManageZoneModel.php';

$conn = Connect();
$zones = getAllZone($conn);
Close($conn);

include '../views/DeliveryManagerManageZone.php';

?>