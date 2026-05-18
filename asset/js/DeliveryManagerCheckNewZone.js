function checkNewZone(form){
	const zoneName = form.zName.value;
	const zoneDelFee = form.zDelFee.value;
	const zoneEstDays = form.zEstDays.value;

	document.getElementById('zNameErr').innerHTML = "";
	document.getElementById('zDelFeeErr').innerHTML = "";
	document.getElementById('zEstDaysErr').innerHTML = "";

	let flag = true;

	if(zoneName == ""){
		document.getElementById('zNameErr').innerHTML = "Please fill up the name!!!";
		flag = false;
	}
	else if(zoneName.length < 4){
		document.getElementById('zNameErr').innerHTML = "Name must be greater than 4 characters!!!";
		flag = false;
	}

	if(zoneDelFee == ""){
		document.getElementById('zDelFeeErr').innerHTML = "Please fill up the delivery fee!!!";
		flag = false;
	}
	else if(isNaN(zoneDelFee)){
		document.getElementById('zDelFeeErr').innerHTML = "Please enter a valid delivery fee!!!";
		flag = false;
	}
	if(zoneEstDays == ""){
		document.getElementById('zEstDaysErr').innerHTML = "Please fill up the estimated days!!!";
		flag = false;
	}
	else if(!Number.isInteger(zoneDelFee)){
		document.getElementById('zEstDaysErr').innerHTML = "Please enter a valid estameted day!!!";
		flag = false;
	}

	return flag;
}