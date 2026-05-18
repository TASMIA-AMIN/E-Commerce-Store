<?php

	if(isset($_SESSION['isLogged'])){
		if($_SESSION['isLogged']){
			header('Location: ../controller/DeliveryManagerDashboardController.php');
			exit();
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delivery Manager Login Page</title>
	<style>
        body{
            font-family: Arial;
            text-align: center;
            background-color: #250a57;
        }
        #login{
		    width: 800px;
    		height: 500px;
		    margin: 100px auto; 
		    text-align: center;

		    background-color:white;     
    		border-radius: 12px;         

		}
		header{
			background-color: white;
		}

        input{
            font-size: 16px;
            padding: 8px;
            width: 200px;
        }

        input[type="submit"]{
            padding: 8px 15px;
            background-color: #250a57;
            color: white;
            border: none;
        }
        input[type="submit"]:hover{
		    background-color: #d46211;
		    color: black;
		}
		form{
		    width: 250px;
		    margin: 100px auto;  /* centers horizontally */
		    text-align: center;  /* inside form content */
		}
    </style>
</head>
<body>
	<?php include '../views/DeliveryManagerHeader.php' ?>
	<div id="login">
		<h1>Deliver Manager Login</h1>
	<form method="post" action= "../controller/DeliveryManagerLoginController.php" onsubmit="return checkLoginFields(this)">
		
		<table id="data">
			<tr>
				<td>
					<label for="userPhone" >Phone Number: </label>
					<br><br>
				</td>
				<td>
					<input type="text" name="userPhone" id="userPhone" >
					<br><br>
				</td>
				<td>
					<span id="userPhoneErr"><?php echo isset($userPhoneErr) ? $userPhoneErr : ""; ?></span>
					<br><br>
				</td>
			</tr>
			<tr>
				<td>
					<label for="userPass" >Password: </label>
					<br><br>
				</td>
				<td>
					<input type="password" name="userPass" id="userPass">
					<br><br>
				</td>
				<td>
					<span id="userPassErr"><?php echo isset($userPassErr) ? $userPassErr : ""; ?></span>
					<br><br>
				</td>
			</tr>
		</table>
		<input type="submit" value="Login">  
	</form>
	<br><br>
	<div id="msg"><?php echo isset($_SESSION['loginMsg']) ? $_SESSION['loginMsg'] : "";
	unset($_SESSION['loginMsg']);
	#
	?></div>
</div>

	<script src=" ../asset/js/DeliveryManagerCheckLogin.js"></script>

</body>
	
</html>