<?php

$action  = $action ?? 'login';
$profile = isset($profile) ? $profile : [];

$flashMsg   = $_SESSION['msg']   ?? '';
$flashError = $_SESSION['error'] ?? '';
$_SESSION['msg']   = '';
$_SESSION['error'] = '';

$isAuthPage = in_array($action, ['login', 'register']);

if (!$isAuthPage) {
    $pageTitle  = 'My Profile';
    $activePage = 'profile';
    include __DIR__ . '/header.php';
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $action === 'register' ? 'Seller Registration' : 'Seller Login'; ?> | E-Commerce</title>
    <link rel="stylesheet" href="../view/css/external.css">
</head>
<body>
<?php } ?>

<?php if ($action === 'login'): ?>

<div class="auth-wrapper">
    <div class="auth-box">
        <h2>🛒 Seller Login</h2>
        <?php if ($flashMsg):   ?><div class="alert alert-success"><?php echo htmlspecialchars($flashMsg);   ?></div><?php endif; ?>
        <?php if ($flashError): ?><div class="alert alert-danger"><?php  echo htmlspecialchars($flashError); ?></div><?php endif; ?>

        <form action="AuthController.php?action=login_save" method="post"
              onsubmit="return validateLogin(this)" novalidate>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="you@example.com" autocomplete="email">
                <span class="err-msg" id="loginEmailErr"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="current-password">
                <span class="err-msg" id="loginPassErr"></span>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
        </form>
        <div class="auth-footer">
            Don't have an account? <a href="AuthController.php?action=register">Register here</a>
        </div>
    </div>
</div>

<?php elseif ($action === 'register'): ?>

<div class="auth-wrapper">
    <div class="auth-box auth-wide">
        <h2>🛒 Create Seller Account</h2>
        <?php if ($flashMsg):   ?><div class="alert alert-success"><?php echo htmlspecialchars($flashMsg);   ?></div><?php endif; ?>
        <?php if ($flashError): ?><div class="alert alert-danger"><?php  echo htmlspecialchars($flashError); ?></div><?php endif; ?>

        <form action="AuthController.php?action=register_save" method="post"
              enctype="multipart/form-data" onsubmit="return validateRegister(this)" novalidate>

            <div class="section-title">Personal Information</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" name="name" id="name">
                    <span class="err-msg" id="regNameErr"></span>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone">
                </div>
            </div>
            <div class="form-group">
                <label for="reg_email">Email Address *</label>
                <input type="email" name="email" id="reg_email">
                <span class="err-msg" id="regEmailErr"></span>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password * <small>(min 6 chars)</small></label>
                    <input type="password" name="password" id="password">
                    <span class="err-msg" id="regPassErr"></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" name="confirm_password" id="confirm_password">
                    <span class="err-msg" id="regConfirmErr"></span>
                </div>
            </div>

            <hr class="auth-divider">
            <div class="section-title">Shop Information</div>

            <div class="form-group">
                <label for="shop_name">Shop Name *</label>
                <input type="text" name="shop_name" id="shop_name">
                <span class="err-msg" id="regShopErr"></span>
            </div>
            <div class="form-group">
                <label for="shop_description">Shop Description</label>
                <textarea name="shop_description" id="shop_description" placeholder="Tell customers about your shop…"></textarea>
            </div>
            <div class="form-group">
                <label for="address">Shop Address *</label>
                <input type="text" name="address" id="address">
                <span class="err-msg" id="regAddrErr"></span>
            </div>
            <div class="form-group">
                <label for="shopLogoInput">Shop Logo</label>
                <input type="file" name="shop_logo" id="shopLogoInput" accept="image/*">
                <small>JPG, PNG or GIF</small><br>
                <img id="shopLogoPreview" src="#" alt=""
                     style="display:none;margin-top:8px;height:72px;border-radius:5px;border:1px solid #ddd">
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Register</button>
        </form>
        <div class="auth-footer">
            Already registered? <a href="AuthController.php?action=login">Login</a>
        </div>
    </div>
</div>

<?php elseif ($action === 'profile'): ?>

<div class="page-header"><h1>My Profile</h1></div>

<div class="card">
    <h2>Shop &amp; Personal Information</h2>
    <form action="SellerDashboardController.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update_profile">
        <div class="form-row">
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name"
                       value="<?php echo htmlspecialchars($profile['name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone"
                       value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Shop Name *</label>
            <input type="text" name="shop_name"
                   value="<?php echo htmlspecialchars($profile['shop_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Shop Description</label>
            <textarea name="shop_description"><?php echo htmlspecialchars($profile['shop_description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>Address *</label>
            <input type="text" name="address"
                   value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Shop Logo</label>
            <?php if (!empty($profile['shop_logo_path'])): ?>
                <br><img id="shopLogoPreview"
                     src="../<?php echo htmlspecialchars($profile['shop_logo_path']); ?>"
                     style="height:72px;margin-bottom:8px;border-radius:5px;border:1px solid #ddd">
            <?php else: ?>
                <img id="shopLogoPreview" src="#" alt=""
                     style="display:none;height:72px;margin-bottom:8px;border-radius:5px;border:1px solid #ddd">
            <?php endif; ?>
            <br>
            <input type="file" name="shop_logo" id="shopLogoInput" accept="image/*">
            <small>Leave blank to keep current logo.</small>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<div class="card">
    <h2>Change Password</h2>
    <form action="SellerDashboardController.php" method="post" onsubmit="return checkPassMatch()">
        <input type="hidden" name="action" value="change_password">
        <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>New Password <small>(min 6 chars)</small></label>
                <input type="password" name="new_password" id="newPass" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirmPass" required>
                <span class="err-msg" id="confirmPassErr"></span>
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Change Password</button>
    </form>
</div>

<?php endif; ?>

<?php if ($isAuthPage): ?>
<script src="../view/js/external.js"></script>
</body>
</html>
<?php else: ?>
<?php include __DIR__ . '/footer.php'; ?>
<?php endif; ?>