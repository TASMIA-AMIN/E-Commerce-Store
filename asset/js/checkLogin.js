function checkLoginFields(form){
	const id = form.userPhone.value;
	const pass = form.userPass.value;

	document.getElementById('userPhoneErr').innerHTML = "";
	document.getElementById('userPassErr').innerHTML = "";
	let flag = true;

	if(id == ""){
		document.getElementById('userPhoneErr').innerHTML = "Please fill up the phone number!!!";
		flag = false;
	}
	if(pass == ""){
	 	document.getElementById('userPassErr').innerHTML = "Please fill up the password!!!";
	 	flag = false;
	}

	return flag;
	
}