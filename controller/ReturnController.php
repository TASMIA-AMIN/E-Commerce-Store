<?php
// controllers/ReturnController.php
// Actions: index | update

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
    $_SESSION['return_requests'] = getReturnRequestsBySeller($conn, $sellerId);
    close($conn);
    include '../views/return.php';
    break;

// ── UPDATE STATUS ─────────────────────────────────────────────
case 'update':
    $returnId = (int)($_POST['return_id'] ?? 0);
    $status   = htmlspecialchars($_POST['status'] ?? '');

    if (!$returnId || !in_array($status, ['approved','rejected','completed'])) {
        $_SESSION['error'] = 'Invalid return action.';
        header('Location: ReturnController.php?action=index'); exit;
    }

    $conn = connect();
    updateReturnStatus($conn, $returnId, $status);
    close($conn);

    $_SESSION['msg'] = 'Return request marked as "' . ucfirst($status) . '".';
    header('Location: ReturnController.php?action=index'); exit;

default:
    header('Location: ReturnController.php?action=index'); exit;
}