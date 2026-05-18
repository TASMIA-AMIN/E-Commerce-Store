<?php
	function checkDuplicate($conn, $zoneName){
		$sql = "SELECT zone_name FROM delivery_zones WHERE LOWER(zone_name) = LOWER('$zoneName')";

		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0){
			return true;
		}
		return false;
	}

	function addZone($conn, $zoneName, $zoneDelFee, $zoneEstDays){
		$sql = "INSERT INTO delivery_zones (zone_name, delivery_fee, estimated_days) VALUES ('$zoneName', '$zoneDelFee', '$zoneEstDays')";

		return mysqli_query($conn, $sql);
	}

?>