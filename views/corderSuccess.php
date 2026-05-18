<?php
session_start();

if(!isset($_SESSION['order_id']))
{
	header("Location:../views/cdashboard.php");
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Order Success</title>
</head>
<body>
	<h2>order placed successfully</h2>
	<p><b>Your Order ID:</b><?php echo $_SESSION['order_id']; ?> </p>
	<p> Thank you for your purchase</p>
	<br>
	<a href="../controllers/corderController.php?action=list">View My Orders</a>
    <br>
    <a href="../views/cdashboard.php">Back to Dashboard</a>
</body>
</html>

