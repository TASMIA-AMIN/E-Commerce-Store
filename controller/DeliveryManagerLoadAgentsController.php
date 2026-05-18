<?php

require_once "../model/DeliveryManagerGeneric.php";
require_once "../model/DeliveryManagerManageAgentsModel.php";

$conn=Connect();

$agents = getAllAgents($conn);
Close($conn);

echo json_encode($agents);
