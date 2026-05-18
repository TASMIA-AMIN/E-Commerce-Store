<?php
	function getAllDailyDelivery($conn){
		$sql = "SELECT 
				    COUNT(CASE WHEN status = 'delivered' THEN 1 END) AS total_delivered,
				    COUNT(CASE WHEN status = 'failed' THEN 1 END) AS total_failed,
				    COUNT(CASE WHEN status = 'in_transit' THEN 1 END) AS total_in_transit,
				    COUNT(
					    CASE 
					        WHEN status IN ('delivered','failed','in_transit')
					        THEN 1
					    END
					) AS total_deliveries
				FROM delivery_assignments
				WHERE DATE(assigned_at) = CURDATE();";

		$result = mysqli_query($conn, $sql);

	    return mysqli_fetch_assoc($result);
	
	}

	function getAllWeeklyDelivery($conn){
		$sql = "SELECT 
				    COUNT(CASE WHEN status = 'delivered' THEN 1 END) AS total_delivered,
				    COUNT(CASE WHEN status = 'failed' THEN 1 END) AS total_failed,
				    COUNT(CASE WHEN status = 'in_transit' THEN 1 END) AS total_in_transit,
				    COUNT(
					    CASE 
					        WHEN status IN ('delivered','failed','in_transit')
					        THEN 1
					    END
					) AS total_deliveries
				FROM delivery_assignments
				WHERE YEARWEEK(assigned_at, 1) = YEARWEEK(CURDATE(), 1);";

		$result = mysqli_query($conn, $sql);

	    return mysqli_fetch_assoc($result);
	
	}

?>