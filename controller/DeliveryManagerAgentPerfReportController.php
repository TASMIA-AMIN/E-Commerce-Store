<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerAgentPerfReportModel.php';

$conn = Connect();
$completedAgents = getAllCompletedAgents($conn);
$failedAgents = getAllFailedAgents($conn);
$timeAgents = getAllTimeAgents($conn);
Close($conn);

include '../views/DeliveryManagerAgentPerfReport.php';

?>