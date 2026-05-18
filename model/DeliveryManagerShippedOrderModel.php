<?php
	function getAllZone($conn){
		$sql = "SELECT * FROM delivery_zones";

		$result = mysqli_query($conn, $sql);

		$zones = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $zones[] = $row;
	        }

	    }

	    return $zones;
	
	}

	function getFreeAgents($conn){
		$sql = "SELECT da.id, da.name, da.phone, da.vehicle_type FROM delivery_agents da WHERE da.id NOT IN (SELECT agent_id FROM delivery_assignments WHERE status IN ('assigned', 'picked_up', 'in_transit'));";

		$result = mysqli_query($conn, $sql);

		$agents = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $agents[] = $row;
	        }

	    }

	    return $agents;
	
	}

	function getAssigningOrders($conn){
		$sql = "SELECT * FROM orders WHERE (status = 'shipped' AND id NOT IN (SELECT order_id FROM delivery_assignments)) OR id IN (SELECT order_id FROM delivery_assignments WHERE status = 'failed');";

		$result = mysqli_query($conn, $sql);

		$orders = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $orders[] = $row;
	        }

	    }

	    return $orders;
	
	}

?>