<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerZonePerfReportModel.php';

$conn = Connect();
$deliveryZones = getAllDeliveryZones($conn);
$timeZones = getAllTimeZones($conn);
Close($conn);

include '../views/DeliveryManagerZonePerfReport.php';

?>