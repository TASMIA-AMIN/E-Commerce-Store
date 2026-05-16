function checkNewAgent(form){
	const agentName = form.aName.value;
	const agentPhone = form.aPhone.value;

	document.getElementById('aPhoneErr').innerHTML = "";
	document.getElementById('aNameErr').innerHTML = "";

	let flag = true;

	if(agentName == ""){
		document.getElementById('aNameErr').innerHTML = "Please fill up the name!!!";
		flag = false;
	}
	if(agentName.length < 4){
		document.getElementById('aNameErr').innerHTML = "Name must be greater than 6 characters!!!";
		flag = false;
	}

	if(agentPhone == ""){
		document.getElementById('aPhoneErr').innerHTML = "Please fill up the phone number!!!";
		flag = false;
	}
	else if(agentPhone.length != 11 || isNaN(agentPhone)){
		document.getElementById('aPhoneErr').innerHTML = "Please enter a valid phone number!!!";
		flag = false;
	}

	return flag;
}