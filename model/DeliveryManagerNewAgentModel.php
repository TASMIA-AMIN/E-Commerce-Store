<?php
	function checkDuplicate($conn, $agentPhone){
		$sql = "SELECT * FROM delivery_agents WHERE phone = '$agentPhone'";

		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0){
			return true;
		}
		return false;
	}

	function addAgent($conn, $user_id, $agentName, $agentPhone, $agentVehicle){
		$sql = "INSERT INTO delivery_agents (user_id, name, phone, vehicle_type, is_active, created_at) VALUES ('$user_id', '$agentName', '$agentPhone', '$agentVehicle', 1, NOW())";

		return mysqli_query($conn, $sql);
	}

?>