<?php
// controllers/CouponController.php
// Actions: index | save | toggle | delete

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header('Location: AuthController.php?action=login'); exit;
}

require_once '../models/Connect.php';
require_once '../models/SellerModel.php';
require_once '../models/Close.php';

$action   = $_GET['action'] ?? $_POST['action'] ?? 'index';
$sellerId = $_SESSION['seller_id'];

// ════════════════════════════════════════════════════════════
switch ($action) {

// ── LIST ─────────────────────────────────────────────────────
case 'index':
    $conn = connect();
    $_SESSION['coupons'] = getCouponsBySeller($conn, $sellerId);
    close($conn);
    include '../views/coupon.php';
    break;

// ── SAVE NEW ─────────────────────────────────────────────────
case 'save':
    $code        = strtoupper(htmlspecialchars(trim($_POST['code']         ?? '')));
    $discountPct = $_POST['discount_pct'] ?? '';
    $maxUses     = $_POST['max_uses']     ?? '';
    $validUntil  = $_POST['valid_until']  ?? '';

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

// ── TOGGLE ───────────────────────────────────────────────────
case 'toggle':
    $couponId = (int)($_POST['coupon_id'] ?? 0);
    $isActive = (int)($_POST['is_active'] ?? 0);
    if ($couponId) {
        $conn = connect();
        toggleCoupon($conn, $couponId, $sellerId, $isActive);
        close($conn);
        $_SESSION['msg'] = 'Coupon status updated.';
    }
    header('Location: CouponController.php?action=index'); exit;

// ── DELETE ───────────────────────────────────────────────────
case 'delete':
    $couponId = (int)($_POST['coupon_id'] ?? 0);
    if ($couponId) {
        $conn = connect();
        deleteCoupon($conn, $couponId, $sellerId);
        close($conn);
        $_SESSION['msg'] = 'Coupon deleted.';
    }
    header('Location: CouponController.php?action=index'); exit;

default:
    header('Location: CouponController.php?action=index'); exit;
}