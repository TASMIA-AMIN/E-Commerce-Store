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