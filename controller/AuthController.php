<?php
// controllers/AuthController.php
// Actions: GET (show login) | register | login | logout

session_start();
require_once '../models/Connect.php';
require_once '../models/SellerModel.php';
require_once '../models/Close.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// ── LOGOUT ──────────────────────────────────────────────────
if ($action === 'logout') {
    session_destroy();
    header('Location: AuthController.php');
    exit;
}

// ── REGISTER SUBMIT ─────────────────────────────────────────
if ($action === 'register') {
    $name     = htmlspecialchars(trim($_POST['name']             ?? ''));
    $email    = htmlspecialchars(trim($_POST['email']            ?? ''));
    $phone    = htmlspecialchars(trim($_POST['phone']            ?? ''));
    $password = $_POST['password']                               ?? '';
    $shopName = htmlspecialchars(trim($_POST['shop_name']        ?? ''));
    $shopDesc = htmlspecialchars(trim($_POST['shop_description'] ?? ''));
    $address  = htmlspecialchars(trim($_POST['address']          ?? ''));

    if (!$name || !$email || !$password || !$shopName || !$address) {
        $_SESSION['error'] = 'Please fill in all required fields.';
        header('Location: AuthController.php?view=register'); exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email address.';
        header('Location: AuthController.php?view=register'); exit;
    }
    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters.';
        header('Location: AuthController.php?view=register'); exit;
    }

    $conn = connect();
    if (emailExists($conn, $email)) {
        $_SESSION['error'] = 'Email already registered.';
        close($conn);
        header('Location: AuthController.php?view=register'); exit;
    }

    $logoPath = '';
    if (isset($_FILES['shop_logo']) && $_FILES['shop_logo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['shop_logo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
            $filename = uniqid('logo_', true) . '.' . $ext;
            move_uploaded_file($_FILES['shop_logo']['tmp_name'], '../uploads/shop_logos/' . $filename);
            $logoPath = 'uploads/shop_logos/' . $filename;
        }
    }

    $userId = registerSellerUser($conn, $name, $email, password_hash($password, PASSWORD_BCRYPT), $phone);
    registerSellerProfile($conn, $userId, $shopName, $shopDesc, $address, $logoPath);
    close($conn);

    $_SESSION['msg'] = 'Registration submitted! Please wait for admin approval.';
    header('Location: AuthController.php'); exit;
}

// ── LOGIN SUBMIT ─────────────────────────────────────────────
if ($action === 'login') {
    $email    = htmlspecialchars(trim($_POST['email']    ?? ''));
    $password = $_POST['password']                       ?? '';

    if (!$email || !$password) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header('Location: AuthController.php'); exit;
    }

    $conn   = connect();
    $seller = getSellerByEmail($conn, $email);
    close($conn);

    if (!$seller || !password_verify($password, $seller['password_hash'])) {
        $_SESSION['error'] = 'Invalid email or password.';
        header('Location: AuthController.php'); exit;
    }
    if (!$seller['is_approved']) {
        $_SESSION['error'] = 'Your account is pending admin approval.';
        header('Location: AuthController.php'); exit;
    }
    if (!$seller['is_active']) {
        $_SESSION['error'] = 'Your account has been suspended.';
        header('Location: AuthController.php'); exit;
    }

    $_SESSION['seller_id']   = $seller['seller_id'];
    $_SESSION['user_id']     = $seller['id'];
    $_SESSION['seller_name'] = $seller['name'];
    $_SESSION['role']        = 'seller';

    header('Location: DashboardController.php'); exit;
}

// ── SHOW FORM (default = login, ?view=register shows register) ──
$view = $_GET['view'] ?? 'login';
require_once '../views/auth.php';