<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login</title>
    <link rel="stylesheet" href="../css/external.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-box">

        <h2>Seller Login</h2>

        <form action="../../controllers/SellerLoginAuthController.php" 
              method="post"
              onsubmit="return validateLogin(this)">

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email">
                <span id="loginEmailErr"></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password">
                <span id="loginPassErr"></span>
            </div>

            <button type="submit" class="btn">Login</button>

        </form>

        <p>
            Don't have an account?
            <a href="../../controllers/SellerRegisterController.php">
                Register
            </a>
        </p>

    </div>
</div>

<script src="../js/external.js"></script>

</body>
</html>