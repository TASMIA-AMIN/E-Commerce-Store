<?php
require_once '../model/DeliveryManagerGeneric.php';
require_once '../model/DeliveryManagerViewAgentModel.php';

$conn = Connect();
$agents = getAllAgents($conn);
Close($conn);

include '../views/DeliveryManagerViewAgent.php';

?>