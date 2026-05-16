<?php
	require_once '../model/DeliveryManagerGeneric.php';
	require_once '../model/DeliveryManagerEditActivateModel.php';
	if($_POST['action'] == "toggleStatus"){
		$id = $_POST['id'];

		$conn = Connect();
		$currentStatus = getCurrentStatus($conn, $id);

		$newStatus = ($currentStatus == 0) ? 1 : 0;
		updateStatus($conn, $newStatus, $id);

		echo $newStatus;
	}

?>