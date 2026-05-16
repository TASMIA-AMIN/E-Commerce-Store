<?php
	function getAllAgents($conn){
		$sql = "SELECT * FROM delivery_agents";

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