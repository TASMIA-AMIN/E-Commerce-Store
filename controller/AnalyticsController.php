<?php 

require_once 'auth_guard.php'; 
require_once '../model/Connect.php'; 
require_once '../model/SellerModel.php'; 
require_once '../model/Close.php'; 

$period = in_array($_GET['period'] ?? '', ['week','month']) ? $_GET['period'] : 'month'; 
$sellerId = $_SESSION['seller_id']; 
$conn = connect(); 
$totalRevenue = getTotalRevenue($conn, $sellerId, $period); 
$topProducts = getTopSellingProducts($conn, $sellerId, 5); 
$orderVolume = getOrderVolumeByDay($conn, $sellerId); 
$avgOrder = getAvgOrderValue($conn, $sellerId); 
$earnings = getEarningsSummary($conn, $sellerId, $period); 
close($conn); 
include '../view/analytics.php'; 
