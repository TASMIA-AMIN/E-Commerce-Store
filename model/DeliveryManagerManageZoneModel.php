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

?>