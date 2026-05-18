<?php
	function getAllDeliveries($conn){
		$sql = "SELECT 
			    da.id AS assignment_id,
			    o.id AS order_id,
			    o.shipping_address,

			    ag.name AS agent_name,
			    ag.phone AS agent_phone,
			    ag.vehicle_type,

			    dz.zone_name,
			    dz.delivery_fee,

			    da.status AS delivery_status,
			    da.assigned_at,

			    o.total_amount,
			    o.created_at AS order_created_at

			FROM delivery_assignments da

			JOIN orders o 
			    ON o.id = da.order_id

			JOIN delivery_agents ag 
			    ON ag.id = da.agent_id

			LEFT JOIN delivery_zones dz 
			    ON dz.id = o.zone_id

			WHERE da.status IN ('delivered', 'failed')

			ORDER BY da.assigned_at DESC;";

		$result = mysqli_query($conn, $sql);

		$deliveries = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $deliveries[] = $row;
	        }

	    }

	    return $deliveries;
	
	}

?>