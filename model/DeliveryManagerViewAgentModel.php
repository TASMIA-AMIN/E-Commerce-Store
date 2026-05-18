<?php
	function getAllAgents($conn){
		$sql = "SELECT da.id, u.name, da.name AS agent_name, da.phone, da.vehicle_type, da.is_active, COUNT(das.id) AS active_deliveries FROM delivery_agents da JOIN users u ON da.user_id = u.id LEFT JOIN delivery_assignments das ON da.id = das.agent_id AND das.status IN ('assigned', 'picked_up', 'in_transit') GROUP BY da.id;";

		$result = mysqli_query($conn, $sql);

		$agents = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $agents[] = $row;
	        }

	    }

	    return $agents;
	
	}

?>