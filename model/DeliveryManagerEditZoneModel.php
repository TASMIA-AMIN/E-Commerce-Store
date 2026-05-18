<?php
function deleteZone($conn, $id){
	$sql = "DELETE FROM delivery_zones WHERE id = '$id'";

	mysqli_query($conn, $sql);
}

function nameExists($conn, $id, $zoneName){
	$sql = "SELECT zone_name FROM delivery_zones WHERE LOWER(zone_name) = LOWER('$zoneName') AND id != '$id'";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		return true;
	}
	return false;
}

function updateZone($conn, $id, $zoneName, $zoneDelFee, $zoneEstDays){

    $sql = "UPDATE delivery_zones SET zone_name='$zoneName', delivery_fee='$zoneDelFee', estimated_days='$zoneEstDays' WHERE id='$id'";

    mysqli_query($conn, $sql);
}

?>