<?php
	function getAllCompletedAgents($conn){
		$sql = "SELECT 
				    ag.id AS agent_id,
				    ag.name AS agent_name,
				    COUNT(da.id) AS total_deliveries
				FROM delivery_agents ag
				LEFT JOIN delivery_assignments da 
				    ON da.agent_id = ag.id
				    AND da.status = 'delivered'
				GROUP BY ag.id, ag.name;";

		$result = mysqli_query($conn, $sql);

		$completedAgents = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $completedAgents[] = $row;
	        }

	    }

	    return $completedAgents;
	
	}

	function getAllFailedAgents($conn){
		$sql = "SELECT 
				    ag.id AS agent_id,
				    ag.name AS agent_name,

				    COUNT(da.id) AS total_jobs,

				    SUM(CASE WHEN da.status = 'failed' THEN 1 ELSE 0 END) AS failed_deliveries,

				    ROUND(
				        (SUM(CASE WHEN da.status = 'failed' THEN 1 ELSE 0 END) / COUNT(da.id)) * 100,
				        2
				    ) AS failed_rate_percent

				FROM delivery_agents ag
				LEFT JOIN delivery_assignments da 
				    ON da.agent_id = ag.id

				GROUP BY ag.id, ag.name;";

		$result = mysqli_query($conn, $sql);

		$failedAgents = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $failedAgents[] = $row;
	        }

	    }

	    return $failedAgents;
	
	}

	function getAllTimeAgents($conn){
		$sql = "SELECT 
				    ag.id AS agent_id,
				    ag.name AS agent_name,

				    AVG(
				        TIMESTAMPDIFF(MINUTE, da.assigned_at, NOW())
				    ) AS avg_delivery_time_minutes

				FROM delivery_agents ag
				JOIN delivery_assignments da 
				    ON da.agent_id = ag.id

				WHERE da.status = 'delivered'

				GROUP BY ag.id, ag.name;";

		$result = mysqli_query($conn, $sql);

		$timeAgents = [];

	    if(mysqli_num_rows($result) > 0){

	        while($row = mysqli_fetch_assoc($result)){
	            $timeAgents[] = $row;
	        }

	    }

	    return $timeAgents;
	
	}

?>