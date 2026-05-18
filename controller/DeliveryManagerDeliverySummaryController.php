<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerDeliverySummaryModel.php';

$conn = Connect();
$daily = getAllDailyDelivery($conn);
$weekly = getAllWeeklyDelivery($conn);
Close($conn);

include '../views/DeliveryManagerDeliverySummary.php';

?>