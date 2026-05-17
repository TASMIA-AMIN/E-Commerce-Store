<?php 

require_once 'auth_guard.php';
require_once '../model/Connect.php'; 
require_once '../model/SellerModel.php'; 
require_once '../model/Close.php'; 

$action = $_GET['action'] ?? $_POST['action'] ?? 'index'; 
$sellerId = $_SESSION['seller_id']; 

switch ($action) { 

case 'index': 
        $conn = connect(); 
        $coupons = getCouponsBySeller($conn, $sellerId); 
        close($conn); 
        include '../view/coupon.php'; 
        break; 

case 'save': 
        $code = strtoupper(htmlspecialchars(trim($_POST['code'] ?? ''))); 
        $discountPct = $_POST['discount_pct'] ?? ''; 
        $maxUses = $_POST['max_uses'] ?? ''; $validUntil = $_POST['valid_until'] ?? ''; 
        if (!$code || !$discountPct || !$maxUses || !$validUntil) { 
        $_SESSION['error'] = 'All coupon fields are required.'; 
        header('Location: CouponController.php?action=index'); exit; 
        } 
        if (!is_numeric($discountPct) || $discountPct <= 0 || $discountPct > 100) { 
        $_SESSION['error'] = 'Discount must be between 1 and 100.'; 
        header('Location: CouponController.php?action=index'); exit; 
        } 
        if (!is_numeric($maxUses) || $maxUses < 1) { 
        $_SESSION['error'] = 'Max uses must be at least 1.'; 
        header('Location: CouponController.php?action=index'); exit; 
        } 
        $conn = connect(); 
        createCoupon($conn, $sellerId, $code, (float)$discountPct, (int)$maxUses, $validUntil); 
        close($conn); 
        $_SESSION['msg'] = 'Coupon created successfully.'; 
        header('Location: CouponController.php?action=index'); exit; 

case 'toggle': 
        $couponId = (int)($_POST['coupon_id'] ?? 0); 
        $isActive = (int)($_POST['is_active'] ?? 0); 
        if ($couponId) { $conn = connect(); toggleCoupon($conn, $couponId, $sellerId, $isActive); 
        close($conn); 
        $_SESSION['msg'] = 'Coupon status updated.'; 
        } 
        header('Location: CouponController.php?action=index'); exit; 

case 'delete': 
        $couponId = (int)($_POST['coupon_id'] ?? 0); 
        if ($couponId) { $conn = connect(); 
        deleteCoupon($conn, $couponId, $sellerId); 
        close($conn); $_SESSION['msg'] = 'Coupon deleted.'; 
        } 
        header('Location: CouponController.php?action=index'); 
        exit; 

default: 
        header('Location: CouponController.php?action=index'); exit; 
        }