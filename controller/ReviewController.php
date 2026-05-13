<?php
// controllers/ReviewController.php
// Actions: index | reply_save

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
    $_SESSION['reviews'] = getReviewsBySeller($conn, $sellerId);
    close($conn);
    include '../views/review.php';
    break;

// ── SAVE REPLY ────────────────────────────────────────────────
case 'reply_save':
    $reviewId = (int)($_POST['review_id'] ?? 0);
    $reply    = htmlspecialchars(trim($_POST['reply'] ?? ''));

    if (!$reviewId || !$reply) {
        $_SESSION['error'] = 'Reply cannot be empty.';
        header('Location: ReviewController.php?action=index'); exit;
    }

    $conn = connect();
    replyToReview($conn, $reviewId, $sellerId, $reply);
    close($conn);

    $_SESSION['msg'] = 'Reply posted successfully.';
    header('Location: ReviewController.php?action=index'); exit;

default:
    header('Location: ReviewController.php?action=index'); exit;
}