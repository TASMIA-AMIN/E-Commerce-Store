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

?>