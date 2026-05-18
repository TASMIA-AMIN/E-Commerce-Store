<?php
	session_start();
	if(!isset($_SESSION['isLogged']) || !$_SESSION['isLogged']){
			header('Location: ../controller/DeliveryManagerLoginController.php');
			exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Assign Agents</title>
	<link rel="stylesheet" href="../asset/css/style.css">
</head>
<body>

	<?php include '../views/DeliveryManagerHeader.php' ?>
	<?php require '../views/DeliveryManagerSideBar.php' ?>

	<mainBody>

	<div id="messageBox" style="display:none; padding:10px; margin-bottom:10px;"></div>

	<div id="confirmBox" style="display:none;"></div>
	
	<h1>Assign Agents</h1>
	<p>Assign Agents to Shipped and Failed Orders</p>

	<?php if(count($orders)>0){ ?>
		<table id="data">
			<thead>
			<tr>
				<th>Order ID</th>
				<th>Customer ID</th>
				<th>Shipping Address</th>
				<th>Payment Method</th>
				<th>Total Amount</th>
				<th>Order Status</th>
				<th>Created At</th>
			</tr>
			</thead>
			<tbody >	
			<?php foreach($orders as $order){ ?>
				<tr>
					<td><?php echo $order['id'] ?></td>
					<td><?php echo $order['customer_id'] ?></td>
					<td><?php echo $order['shipping_address'] ?></td>
					<td><?php echo $order['payment_method'] ?></td>
					<td><?php echo $order['total_amount'] ?></td>
					<td><?php echo $order['status'] ?></td>
					<td><?php echo $order['created_at'] ?></td>
					<td><button onclick="showEdit(<?php echo $order['id']; ?>)">Assign</button></td>
				</tr>
			</div>
				<tr id="editRow<?php echo $order['id']; ?>" style="display:none;">
					<td colspan="6">
						<table>
							<tr>
								<td>
									<label for="assignZone<?php echo $order['id']; ?>">Zone: </label>
									<br><br>
								</td>
								<td>
									<select id="assignZone<?php echo $order['id']; ?>">
									    <?php foreach($zones as $z){ ?>
									        <option value="<?php echo $z['id']; ?>">
									            <?php echo $z['zone_name']; ?>
									        </option>
									    <?php } ?>
									</select>
									<br><br>
								</td>
							</tr>
							<tr>
								<td>
									<label for="assignAgent<?php echo $order['id']; ?>" >Agent: </label>
									<br><br>
								</td>
								<td>

								<?php if(count($agents) > 0){ ?>
								    <select id="assignAgent<?php echo $order['id']; ?>">
								        <?php foreach($agents as $a){ ?>
								            <option value="<?php echo $a['id']; ?>">
								                <?php echo $a['name']; ?> (<?php echo $a['vehicle_type']; ?>)
								            </option>
								        <?php } ?>
								    </select>
								    <br><br>
								<?php } else { ?>
								    <select disabled>
								        <option>No Free Agents Available</option>
								    </select>
								    <br><br>
								<?php } ?>
								</td>
							</tr>
						</table>

						<button onclick="assignAgent(<?php echo $order['id']; ?>)">Assign</button>
						<button onclick="hideEdit(<?php echo $order['id']; ?>)">Cancel</button>
						<br><br>
				</div>
			<?php } ?>
			
		</table>
	</td>
</tr>
</tbody>
</table>
	<?php }
	else{ ?>
		<div><?php echo "Currently No Active Order!!!"; ?></div>
	<?php } ?>

	</mainBody>

	<script src="../asset/js/DeliveryManagerAssignAgent.js"></script>
	

</body>
</html>