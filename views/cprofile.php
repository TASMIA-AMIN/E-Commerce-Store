<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>My Profile</title>
</head>
<body>
	<h2>My Profile</h2>
	<p>Welcome <?php echo $_SESSION['user_name']; ?></p>

	<?php if(!empty($user)): ?>
		<form action="../controllers/cprofileController.php?action=update" method="POST" enctype="multipart/form-data">
			<label for="name">Name: </label>
			<input type="text" name="name" id="name" value="<?php echo $user['name']; ?>">
			<br><br>

			<label for="email">Email: </label>
			<input type="text" name="email" id="email" value="<?php echo $user['email']; ?>">
			<br><br>

			<label for="phone">Phone: </label>
			<input type="text" name="phone" id="phone" value="<?php echo $user['phone']; ?>">
			<br><br>

			<label>Profile Picture: </label>
			<input type="file" name="profile_pic" id="profile_pic">
			<br><br>

			<?php if(!empty($user['profile_pic'])): ?>
				<img src="../<?php echo $user['profile_pic']; ?>" width="100">
			<?php endif; ?>
			<br><br>

			<button type="submit">Update Profile</button>
		</form>

		<hr>

		<h3>Change Password</h3>
		<form action="../controllers/cprofileController.php?action=password" method="POST">
			<label>New Password: </label>
			<input type="password" name="new_password">
			<br><br>

			<button type="submit">Change Password</button>
		</form>
		<?php else: ?>
	       <p>User not found</p>

	<?php endif; ?>
	<br>
	<a href="cdashboard.php">Back to Dashboard</a>
</body>
</html>


