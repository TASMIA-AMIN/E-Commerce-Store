<?php
	require_once '../model/DeliveryManagerGeneric.php';
	require_once '../model/DeliveryManagerDashboardModel.php';

	$conn = Connect();
	$pendingDispatch = pendingDispatchCount($conn);
	$activeDelivery = activeDeliveryCount($conn);
	$deliveredToday = deliveredTodayCount($conn);
	Close($conn);

	include '../views/DeliveryManagerDashboard.php';

?>