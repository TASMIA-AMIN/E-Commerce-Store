<?php
function getCurrentStatus($conn, $id){
	$sql = "SELECT is_active FROM delivery_agents WHERE id = '$id'";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		return $row['is_active'];
	}
}

function updateStatus($conn, $newStatus, $id){
	$sql = "UPDATE delivery_agents SET is_active = '$newStatus' WHERE id = '$id'";

	return mysqli_query($conn, $sql);
}

function phoneExists($conn, $id, $phone){
	$sql = "SELECT phone FROM delivery_agents WHERE phone = '$phone' AND id != '$id'";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		return true;
	}
	return false;
}

function updateAgent($conn, $id, $name, $phone, $vehicle){

    $sql = "UPDATE delivery_agents SET name='$name', phone='$phone', vehicle_type='$vehicle' WHERE id='$id'";

    mysqli_query($conn, $sql);
}

?>