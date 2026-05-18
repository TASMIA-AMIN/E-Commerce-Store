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

let callback = null;

function showConfirm(msg, cb){

    const box = document.getElementById("confirmBox");

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
            text-align:center;
        ">
            <p>${msg}</p>

            <button id="yesBtn">Yes</button>
            <button onclick="document.getElementById('confirmBox').style.display='none'">No</button>
        </div>
    `;

    callback = cb;

    document.getElementById("yesBtn").onclick = function(){
        box.style.display = "none";
        if(callback) callback();
    };
}

function changeStatus(id){

    const status = document.getElementById("assignStatus" + id).value;

    showConfirm("Are you sure you want to change status?", function(){

    const xhr = new XMLHttpRequest();

    xhr.onload = function(){

        const result = JSON.parse(this.responseText);

        if(result.status == "success"){
            showMessage(result.status, result.message);
            setTimeout(function(){
		        window.location.href = "../controller/DeliveryManagerActiveDeliveryController.php";
		    }, 2000);
        }
        else{
            showMessage(result.status, result.message);
            setTimeout(function(){
			    document.getElementById("messageBox").style.display = "none";
			}, 2000);
        }
    };

    xhr.open("POST", "../controller/DeliveryManagerChangeOrderStatusController.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.send("action=changeStatus&id="+id+"&status="+status);
	});
}

function showEdit(id){
	document.getElementById("editRow" + id).style.display = "table-row";
}

function hideEdit(id){
	document.getElementById("editRow" + id).style.display = "none";
}

