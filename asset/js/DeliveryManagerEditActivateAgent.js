function showMessage(type, message){

    const box = document.getElementById("messageBox");

    box.style.display = "flex";            
    box.style.position = "fixed";
    box.style.top = "0";
    box.style.left = "0";
    box.style.width = "100%";
    box.style.height = "100%";
    box.style.background = "rgba(0,0,0,0.3)";
    box.style.justifyContent = "center";
    box.style.alignItems = "center";

    box.innerHTML = `
        <div style="
            background:white;
            padding:20px;
            border:1px solid black;
            border-radius:8px;
            min-width:200px;
            text-align:center;
        ">
            ${message}
        </div>
    `;
}

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
			showMessage(result.status, result.message);
			setTimeout(function(){
		        window.location.href = "../controller/DeliveryManagerManageAgentController.php";
		    }, 2000);
			//loadAgents();
		}
		else if(result.status == "error"){
			showMessage(result.status, result.message);
			setTimeout(function(){
		        document.getElementById("messageBox").style.display = "none";
		    }, 2000);

		}
		else{
			showMessage("error",this.responseText);
			setTimeout(function(){
		        document.getElementById("messageBox").style.display = "none";
		    }, 2000);
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

