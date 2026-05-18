<?php

 require_once 'auth_guard.php'; 
 require_once '../model/Connect.php'; 
 require_once '../model/SellerModel.php'; 
 require_once '../model/Close.php'; 

 $action = $_GET['action'] ?? $_POST['action'] ?? 'index'; 
 $sellerId = $_SESSION['seller_id']; 
 switch ($action) { 

 case 'index': 
        $statusFilter = htmlspecialchars(trim($_GET['status'] ?? '')); 
        $conn = connect(); 
        $orders = getOrdersBySeller($conn, $sellerId, $statusFilter); 
        close($conn); 
        include '../view/order.php'; 
        break; 
     
case 'detail': 
        $orderId = (int)($_GET['id'] ?? 0); if (!$orderId) { 
        header('Location: OrderController.php?action=index'); 
        exit; 
        } 
        $conn = connect(); 
        $data = getOrderDetail($conn, $orderId, $sellerId); 
        close($conn); 
        if (!$data['order']) { 
        header('Location: OrderController.php?action=index'); 
        exit; 
        } 
        $order = $data['order']; 
        $items = $data['items']; 
        include '../view/order.php'; 
        break; 
case 'update_status': 
        $itemId = (int)($_POST['item_id'] ?? 0); 
        $orderId = (int)($_POST['order_id'] ?? 0); 
        $newStatus = htmlspecialchars(trim($_POST['new_status'] ?? '')); 
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