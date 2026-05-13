<?php
// views/seller/register.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Register</title>
    <link rel="stylesheet" href="../css/seller.css">
</head>

<body>

<div class="auth-wrapper">
    <div class="auth-box">

        <h2>Create Seller Account</h2>

        <form action="../../controllers/SellerRegisterSaveController.php"
              method="post"
              enctype="multipart/form-data"
              onsubmit="return validateRegister(this)">

            <h3>Personal Information</h3>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" id="name">
                <span id="regNameErr"></span>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" id="phone">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email">
                <span id="regEmailErr"></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password">
                <span id="regPassErr"></span>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password">
                <span id="regConfirmErr"></span>
            </div>

            <h3>Shop Information</h3>

            <div class="form-group">
                <label>Shop Name</label>
                <input type="text" name="shop_name" id="shop_name">
                <span id="regShopErr"></span>
            </div>

            <div class="form-group">
                <label>Shop Description</label>
                <textarea name="shop_description" id="shop_description"></textarea>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" id="address">
                <span id="regAddrErr"></span>
            </div>

            <div class="form-group">
                <label>Shop Logo</label>
                <input type="file" name="shop_logo" id="shopLogoInput">
            </div>

            <button type="submit" class="btn">
                Register
            </button>

        </form>

        <p>
            Already have an account?
            <a href="../../controllers/SellerLoginController.php">
                Login
            </a>
        </p>

    </div>
</div>

<script src="../js/external.js"></script>

</body>
</html>
                