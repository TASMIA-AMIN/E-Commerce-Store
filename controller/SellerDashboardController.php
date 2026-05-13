<?php
// controllers/DashboardController.php
// Also handles Profile update and Password change via action param

require_once 'auth_guard.php';
require_once '../models/Connect.php';
require_once '../models/SellerModel.php';
require_once '../models/Close.php';

$action = $_POST['action'] ?? '';

// ── UPDATE PROFILE ───────────────────────────────────────────
if ($action === 'update_profile') {
    $name     = htmlspecialchars(trim($_POST['name']             ?? ''));
    $phone    = htmlspecialchars(trim($_POST['phone']            ?? ''));
    $shopName = htmlspecialchars(trim($_POST['shop_name']        ?? ''));
    $shopDesc = htmlspecialchars(trim($_POST['shop_description'] ?? ''));
    $address  = htmlspecialchars(trim($_POST['address']          ?? ''));

    if (!$name || !$shopName || !$address) {
        $_SESSION['error'] = 'Name, Shop Name, and Address are required.';
        header('Location: DashboardController.php?view=profile'); exit;
    }

    $conn    = connect();
    $profile = getSellerProfile($conn, $_SESSION['seller_id']);
    $logoPath = $profile['shop_logo_path'];

    if (isset($_FILES['shop_logo']) && $_FILES['shop_logo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['shop_logo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
            $filename = uniqid('logo_', true) . '.' . $ext;
            move_uploaded_file($_FILES['shop_logo']['tmp_name'], '../uploads/shop_logos/' . $filename);
            $logoPath = 'uploads/shop_logos/' . $filename;
        }
    }

    updateSellerProfile($conn, $_SESSION['seller_id'], $shopName, $shopDesc, $address, $logoPath, $name, $phone, $_SESSION['user_id']);
    close($conn);

    $_SESSION['seller_name'] = $name;
    $_SESSION['msg']         = 'Profile updated successfully.';
    header('Location: DashboardController.php?view=profile'); exit;
}

// ── CHANGE PASSWORD ──────────────────────────────────────────
if ($action === 'change_password') {
    $current = $_POST['current_password']  ?? '';
    $new     = $_POST['new_password']      ?? '';
    $confirm = $_POST['confirm_password']  ?? '';

    if (!$current || !$new || !$confirm) {
        $_SESSION['error'] = 'All password fields are required.';
        header('Location: DashboardController.php?view=profile'); exit;
    }
    if ($new !== $confirm) {
        $_SESSION['error'] = 'New passwords do not match.';
        header('Location: DashboardController.php?view=profile'); exit;
    }
    if (strlen($new) < 6) {
        $_SESSION['error'] = 'New password must be at least 6 characters.';
        header('Location: DashboardController.php?view=profile'); exit;
    }

    $conn    = connect();
    $profile = getSellerProfile($conn, $_SESSION['seller_id']);

    if (!password_verify($current, $profile['password_hash'])) {
        $_SESSION['error'] = 'Current password is incorrect.';
        close($conn);
        header('Location: DashboardController.php?view=profile'); exit;
    }

    changeSellerPassword($conn, $_SESSION['user_id'], password_hash($new, PASSWORD_BCRYPT));
    close($conn);

    $_SESSION['msg'] = 'Password changed successfully.';
    header('Location: DashboardController.php?view=profile'); exit;
}

// ── LOAD DATA & SHOW VIEW ────────────────────────────────────
$view = $_GET['view'] ?? 'dashboard';
$conn = connect();

if ($view === 'profile') {
    $data = getSellerProfile($conn, $_SESSION['seller_id']);
} else {
    $data = [
        'low_stock'     => getLowStockProducts($conn, $_SESSION['seller_id'], 5),
        'recent_orders' => getOrdersBySeller($conn, $_SESSION['seller_id'], ''),
        'earnings'      => getEarningsSummary($conn, $_SESSION['seller_id'], 'month'),
        'top_products'  => getTopSellingProducts($conn, $_SESSION['seller_id'], 5),
    ];
}

close($conn);
require_once '../views/dashboard.php';