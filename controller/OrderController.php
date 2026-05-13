<?php
// controllers/OrderController.php
// Actions: index | detail | update_status

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
    $statusFilter = htmlspecialchars(trim($_GET['status'] ?? ''));
    $conn = connect();
    $_SESSION['orders']       = getOrdersBySeller($conn, $sellerId, $statusFilter);
    $_SESSION['order_filter'] = $statusFilter;
    close($conn);
    include '../views/order.php';
    break;

// ── DETAIL ───────────────────────────────────────────────────
case 'detail':
    $orderId = (int)($_GET['id'] ?? 0);
    if (!$orderId) { header('Location: OrderController.php?action=index'); exit; }

    $conn = connect();
    $data = getOrderDetail($conn, $orderId, $sellerId);
    close($conn);

    if (!$data['order']) { header('Location: OrderController.php?action=index'); exit; }

    $_SESSION['order_detail'] = $data;
    include '../views/order.php';
    break;

// ── UPDATE ITEM STATUS ────────────────────────────────────────
case 'update_status':
    $itemId    = (int)($_POST['item_id']   ?? 0);
    $orderId   = (int)($_POST['order_id']  ?? 0);
    $newStatus = htmlspecialchars($_POST['new_status'] ?? '');

    if (!$itemId || !$orderId || !in_array($newStatus, ['confirmed','shipped','delivered'])) {
        $_SESSION['error'] = 'Invalid request.';
        header('Location: OrderController.php?action=detail&id=' . $orderId); exit;
    }

    $conn = connect();
    updateItemStatus($conn, $itemId, $sellerId, $newStatus);
    close($conn);

    $_SESSION['msg'] = 'Item status updated to "' . ucfirst($newStatus) . '".';
    header('Location: OrderController.php?action=detail&id=' . $orderId); exit;

default:
    header('Location: OrderController.php?action=index'); exit;
}