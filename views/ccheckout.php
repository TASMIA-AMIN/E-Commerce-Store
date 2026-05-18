<?php
if(!isset($_SESSION))
{
	session_start();
}
?>

<h2>Checkout</h2>
<form method="post" action="../controllers/corderController.php?action=place">

	<label>Address:</label><br>
	<input type="text" name="address"><br><br>

	<label>Delivery Zone:</label><br>
	<select name="delivery_zone">
		<option>Dhaka City</option>
		<option>Outside Dhaka</option>
	</select><br><br>

	<label>Payment Method:</label><br>
	<select name="payment_method">
		<option value="cash_on_delivery">COD</option>
		<option value="card">Card</option>
	</select><br><br>

	<button type="submit">Place Order</button>

</form>