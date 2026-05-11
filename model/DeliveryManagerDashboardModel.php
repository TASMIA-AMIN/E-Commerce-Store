<?php
	function pendingDispatchCount($conn){

		$sql = "SELECT COUNT(*) AS total FROM delivery_assignments WHERE status = 'assigned'";

		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);

			return $row['total'];
		}
		return 0;
	}

	function activeDeliveryCount($conn){

		$sql = "SELECT COUNT(*) AS total FROM delivery_assignments WHERE status IN ('assigned', 'picked_up', 'in_transit')";

		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);

			return $row['total'];
		}
		return 0;
	}

	function deliveredTodayCount($conn){

		$sql = "SELECT COUNT(*) AS total FROM delivery_assignments WHERE status = 'delivered' AND DATE(delivered_at) = CURDATE()";

		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);

			return $row['total'];
		}
		return 0;
	}

?>