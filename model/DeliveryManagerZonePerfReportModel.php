<?php
	function getAllDeliveryZones($conn){
		$sql = "SELECT 
				    dz.id AS zone_id,
				    dz.zone_name,

				    COUNT(da.id) AS total_deliveries

				FROM delivery_zones dz
				LEFT JOIN orders o 
				    ON o.zone_id = dz.id
				LEFT JOIN delivery_assignments da 
				    ON da.order_id = o.id

				GROUP BY dz.id, dz.zone_name;";

		$result = mysqli_query($conn, $sql);

		$deliveryZones = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $deliveryZones[] = $row;
	        }

	    }

	    return $deliveryZones;
	
	}

	function getAllTimeZones($conn){
		$sql = "SELECT 
				    dz.id AS zone_id,
				    dz.zone_name,

				    AVG(
				        TIMESTAMPDIFF(MINUTE, da.assigned_at, NOW())
				    ) AS avg_delivery_time_minutes

				FROM delivery_zones dz
				JOIN orders o 
				    ON o.zone_id = dz.id
				JOIN delivery_assignments da 
				    ON da.order_id = o.id

				WHERE da.status = 'delivered'

				GROUP BY dz.id, dz.zone_name;";

		$result = mysqli_query($conn, $sql);

		$timeZones = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $timeZones[] = $row;
	        }

	    }

	    return $timeZones;
	
	}

?>