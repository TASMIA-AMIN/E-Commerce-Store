<?php
	function getAllActiveAssignments($conn){
		$sql = "SELECT da.id AS assignment_id, o.id AS order_id, o.shipping_address, ag.name AS agent_name, ag.vehicle_type, ag.phone AS agent_phone, dz.zone_name, da.status,TIMESTAMPDIFF(MINUTE, da.assigned_at, NOW()) AS minutes_since_assignment FROM delivery_assignments da JOIN orders o ON o.id = da.order_id JOIN delivery_agents ag ON ag.id = da.agent_id LEFT JOIN delivery_zones dz ON dz.id = o.zone_id WHERE da.status IN ('assigned','picked_up','in_transit');";

		$result = mysqli_query($conn, $sql);

		$assignments = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $assignments[] = $row;
	        }

	    }

	    return $assignments;
	
	}
?>