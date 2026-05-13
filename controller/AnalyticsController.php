<?php
// controllers/AnalyticsController.php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
    header('Location: AuthController.php?action=login'); exit;
}

require_once '../models/Connect.php';
require_once '../models/SellerModel.php';
require_once '../models/Close.php';

$period   = in_array($_GET['period'] ?? '', ['week','month']) ? $_GET['period'] : 'month';
$sellerId = $_SESSION['seller_id'];

$conn = connect();
$_SESSION['analytics'] = [
    'period'        => $period,
    'total_revenue' => getTotalRevenue($conn, $sellerId, $period),
    'top_products'  => getTopSellingProducts($conn, $sellerId, 5),
    'order_volume'  => getOrderVolumeByDay($conn, $sellerId),
    'avg_order'     => getAvgOrderValue($conn, $sellerId),
    'earnings'      => getEarningsSummary($conn, $sellerId, $period),
];
close($conn);

include '../views/analytics.php';