<?php

if (session_status() === PHP_SESSION_NONE) 
session_start();

$flashMsg   = $_SESSION['msg']   ?? '';
$flashError = $_SESSION['error'] ?? '';
$_SESSION['msg']   = '';
$_SESSION['error'] = '';

$pageTitle  = $pageTitle  ?? 'Seller Panel';
$activePage = $activePage ?? '';

function navClass($page) {
    global $activePage;
    return $activePage === $page ? ' class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?> | E-Commerce Seller</title>
    <link rel="stylesheet" href="../view/css/external.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-brand">🛒 My Shop</div>
    <div class="nav-links">
        <a href="SellerDashboardController.php"<?php echo navClass('dashboard'); ?>>Dashboard</a>
        <a href="ProductController.php"<?php echo navClass('products'); ?>>Products</a>
        <a href="OrderController.php?action=index"<?php echo navClass('orders'); ?>>Orders</a>
        <a href="CouponController.php?action=index"<?php echo navClass('coupons'); ?>>Coupons</a>
        <a href="ReturnController.php?action=index"<?php echo navClass('returns'); ?>>Returns</a>
        <a href="ReviewController.php?action=index"<?php echo navClass('reviews'); ?>>Reviews</a>
        <a href="AnalyticsController.php"<?php echo navClass('analytics'); ?>>Analytics</a>
        <a href="SellerDashboardController.php?view=profile"<?php echo navClass('profile'); ?>>
            👤 <?php echo htmlspecialchars($_SESSION['seller_name'] ?? 'Profile'); ?>
        </a>
        <a href="AuthController.php?action=logout" class="nav-logout">Logout</a>
    </div>
</nav>

<div class="container">
<?php if ($flashMsg):   ?><div class="alert alert-success"><?php echo htmlspecialchars($flashMsg);   ?></div><?php endif; ?>
<?php if ($flashError): ?><div class="alert alert-danger"><?php  echo htmlspecialchars($flashError); ?></div><?php endif; ?>