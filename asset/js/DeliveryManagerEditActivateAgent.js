function agentStatusChange(id, button){
	const xhr = new XMLHttpRequest();
	xhr.onload = function(){
		let status = this.responseText;

		if(status == 1){
			button.innerHTML = "Deactivate";
		}
		else{
			button.innerHTML = "Activate";
		}
	};

	xhr.open("POST", "../controller/DeliveryManagerEditActivateController.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("action=toggleStatus&id=" + id);
}


function updateAgent(id){

	const name = document.getElementById("aNameEdit" + id).value;
    const phone = document.getElementById("aPhoneEdit" + id).value;
    const vehicle = document.getElementById("aVehicleEdit" + id).value;


	const xhr = new XMLHttpRequest();
	xhr.onload = function(){
		const result = JSON.parse(this.responseText);
		if(result.status == "success"){
			alert(result.message);
			window.location.href = "../controller/DeliveryManagerManageAgentController.php";
			//loadAgents();
		}
		else if(result.status == "error"){
			alert(result.message);

		}
		else{
			alert(this.responseText);
		}
	};

	xhr.open("POST", "../controller/DeliveryManagerEditActivateController.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.send("action=updateAgent"+"&id="+id+"&name="+name+"&phone="+phone+"&vehicle="+vehicle);
}

function showEdit(id){
	document.getElementById("editRow" + id).style.display = "table-row";
}

function hideEdit(id){
	document.getElementById("editRow" + id).style.display = "none";
}

function loadAgents(){

	const xhr = new XMLHttpRequest();
	xhr.onload = function(){
		let agents = JSON.parse(this.responseText);
		let rows = "";
		for(let i=0; i<agents.length; i++){
			rows+=`
				<tr>
					<td>${agents[i].id}</td>
					<td>${agents[i].user_id}</td>
					<td>${agents[i].name}</td>
					<td>${agents[i].phone}</td>
					<td>${agents[i].vehicle_type}</td>
					<td>
                        <button type="button" onclick="agentEdit(${agents[i].id})"> Edit </button>
                    </td>
                    <td>
                        <button type="button" onclick="agentStatusChange(${agents[i].id}, this)"> ${agents[i].is_active == 1 ? "Deactivate" : "Activate"} </button>
                    </td>
				</tr>
			`;
		}
		document.getElementById("agentTable").innerHTML = rows;
	};

    xhr.open("GET", "../controller/DeliveryManagerLoadAgentsController.php", true);

    xhr.send();
}