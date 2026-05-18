<?php

function getSellerByEmail($conn, $email)
{
    $email  = htmlspecialchars(strip_tags(trim($email)));
    $sql    = "SELECT u.*, s.id AS seller_id, s.is_approved, s.is_active
               FROM users u
               JOIN sellers s ON u.id = s.user_id
               WHERE u.email = '$email' AND u.role = 'seller'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function emailExists($conn, $email)
{
    $email  = htmlspecialchars(strip_tag(trim($email)));
    $sql    = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

function registerSellerUser($conn, $name, $email, $passwordHash, $phone)
{
    $name         = htmlspecialchars(strip_tags(trim($name)));
    $email        = htmlspecialchars(strip_tags(trim($email)));
    $passwordHash = htmlspecialchars(strip_tags(trim($passwordHash)));
    $phone        = htmlspecialchars(strip_tags(trim($phone)));
    $sql = "INSERT INTO users (name, email, password, phone, role)
            VALUES ('$name', '$email', '$passwordHash', '$phone', 'seller')";
    mysqli_query($conn, $sql);
    return mysqli_insert_id($conn);
}

function registerSellerProfile($conn, $userId, $shopName, $shopDesc, $address, $logoPath)
{
    $userId   = (int)$userId;
    $shopName = htmlspecialchars(strip_tags(trim($shopName)));
    $shopDesc = htmlspecialchars(strip_tags(trim($shopDesc)));
    $address  = htmlspecialchars(strip_tags(trim($address)));
    $logoPath = htmlspecialchars(strip_tags(trim($logoPath)));
    $sql = "INSERT INTO sellers (user_id, shop_name, shop_description, address, shop_logo_path)
            VALUES ('$userId', '$shopName', '$shopDesc', '$address', '$logoPath')";
    mysqli_query($conn, $sql);
    return mysqli_insert_id($conn);
}

function getSellerProfile($conn, $sellerId)
{
    $sellerId = (int)$sellerId;
    $sql = "SELECT s.*, u.name, u.email, u.phone, u.password
            FROM sellers s
            JOIN users u ON s.user_id = u.id
            WHERE s.id = '$sellerId'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function updateSellerProfile($conn, $sellerId, $shopName, $shopDesc, $address, $logoPath, $name, $phone, $userId)
{
    $sellerId = (int)$sellerId;
    $userId   = (int)$userId;
    $shopName = htmlspecialchars(strip_tags(trim($shopName)));
    $shopDesc = htmlspecialchars(strip_tags(trim($shopDesc)));
    $address  = htmlspecialchars(strip_tags(trim($address)));
    $logoPath = htmlspecialchars(strip_tags(trim($logoPath)));
    $name     = htmlspecialchars(strip_tags(trim($name)));
    $phone    = htmlspecialchars(strip_tags(trim($phone)));

    $sql1 = "UPDATE sellers
             SET shop_name='$shopName', shop_description='$shopDesc',
                 address='$address', shop_logo_path='$logoPath'
             WHERE id='$sellerId'";
    mysqli_query($conn, $sql1);

    $sql2 = "UPDATE users SET name='$name', phone='$phone' WHERE id='$userId'";
    return mysqli_query($conn, $sql2);
}

function changeSellerPassword($conn, $userId, $newPassword)
{
    $userId  = (int)$userId;
    $newPassword = htmlspecialchars(strip_tags(trim($newPassword)));
    $sql     = "UPDATE users SET password='$newPassword' WHERE id='$userId'";
    return mysqli_query($conn, $sql);
}

function getAllCategories($conn)
{
    $sql = "SELECT c.id, c.name, p.name AS parent_name
            FROM categories c
            LEFT JOIN categories p ON c.parent_id = p.id
            ORDER BY p.name, c.name";
    $result = mysqli_query($conn, $sql);
    $cats   = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $cats[] = $row;
    }
    return $cats;
}

function getProductsBySeller($conn, $sellerId)
{
    $sellerId = (int)$sellerId;
    $sql = "SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.seller_id = '$sellerId'
            ORDER BY p.created_at DESC";
    $result   = mysqli_query($conn, $sql);
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

function getProductById($conn, $productId, $sellerId)
{
    $productId = (int)$productId;
    $sellerId  = (int)$sellerId;
    $sql = "SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.id = '$productId' AND p.seller_id = '$sellerId'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getProductImages($conn, $productId)
{
    $productId = (int)$productId;
    $sql    = "SELECT * FROM product_images WHERE product_id = '$productId' ORDER BY display_order";
    $result = mysqli_query($conn, $sql);
    $imgs   = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $imgs[] = $row;
    }
    return $imgs;
}

function createProduct($conn, $sellerId, $categoryId, $name, $description, $price, $stockQty, $primaryImagePath)
{
    $sellerId         = (int)$sellerId;
    $categoryId       = (int)$categoryId;
    $price            = (float)$price;
    $stockQty         = (int)$stockQty;
    $name             = htmlspecialchars(strip_tags(trim($name)));
    $description      = htmlspecialchars(strip_tags(trim($description)));
    $primaryImagePath = htmlspecialchars(strip_tags(trim($primaryImagePath)));
    $sql = "INSERT INTO products (seller_id, category_id, name, description, price, stock_qty, primary_image_path)
            VALUES ('$sellerId', '$categoryId', '$name', '$description', '$price', '$stockQty', '$primaryImagePath')";
    mysqli_query($conn, $sql);
    return mysqli_insert_id($conn);
}

function addProductImage($conn, $productId, $imagePath, $order)
{
    $productId = (int)$productId;
    $order     = (int)$order;
    $imagePath = htmlspecialchars(strip_tags(trim($imagePath)));
    $sql = "INSERT INTO product_images (product_id, image_path, display_order)
            VALUES ('$productId', '$imagePath', '$order')";
    return mysqli_query($conn, $sql);
}

function updateProduct($conn, $productId, $sellerId, $categoryId, $name, $description, $price, $stockQty, $primaryImagePath)
{
    $productId        = (int)$productId;
    $sellerId         = (int)$sellerId;
    $categoryId       = (int)$categoryId;
    $price            = (float)$price;
    $stockQty         = (int)$stockQty;
    $name             = htmlspecialchars(strip_tags(trim($name)));
    $description      = htmlspecialchars(strip_tags(trim($description)));
    $primaryImagePath = htmlspecialchars(strip_tags(trim($primaryImagePath)));
    $sql = "UPDATE products
            SET category_id='$categoryId', name='$name', description='$description',
                price='$price', stock_qty='$stockQty', primary_image_path='$primaryImagePath'
            WHERE id='$productId' AND seller_id='$sellerId'";
    return mysqli_query($conn, $sql);
}

function toggleProductAvailability($conn, $productId, $sellerId, $isAvailable)
{
    $productId   = (int)$productId;
    $sellerId    = (int)$sellerId;
    $isAvailable = (int)$isAvailable;
    $sql = "UPDATE products SET is_available='$isAvailable'
            WHERE id='$productId' AND seller_id='$sellerId'";
    return mysqli_query($conn, $sql);
}

function productHasPendingOrders($conn, $productId)
{
    $productId = (int)$productId;
    $sql = "SELECT id FROM order_items
            WHERE product_id = '$productId'
            AND item_status IN ('pending','confirmed','shipped')";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

function deleteProduct($conn, $productId, $sellerId)
{
    $productId = (int)$productId;
    $sellerId  = (int)$sellerId;
    $sql = "DELETE FROM products WHERE id='$productId' AND seller_id='$sellerId'";
    return mysqli_query($conn, $sql);
}

function getLowStockProducts($conn, $sellerId, $threshold = 5)
{
    $sellerId  = (int)$sellerId;
    $threshold = (int)$threshold;
    $sql = "SELECT id, name, stock_qty FROM products
            WHERE seller_id = '$sellerId'
            AND stock_qty <= '$threshold'
            AND is_available = 1";
    $result   = mysqli_query($conn, $sql);
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

function getCouponsBySeller($conn, $sellerId)
{
    $sellerId = (int)$sellerId;
    $sql      = "SELECT * FROM coupons WHERE seller_id='$sellerId' ORDER BY valid_until DESC";
    $result   = mysqli_query($conn, $sql);
    $coupons  = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $coupons[] = $row;
    }
    return $coupons;
}

function createCoupon($conn, $sellerId, $code, $discountPct, $maxUses, $validUntil)
{
    $sellerId    = (int)$sellerId;
    $discountPct = (float)$discountPct;
    $maxUses     = (int)$maxUses;
    $code        = htmlspecialchars(strip_tags(trim($code)));
    $validUntil  = htmlspecialchars(strip_tags(trim($validUntil)));
    $sql = "INSERT INTO coupons (seller_id, code, discount_pct, max_uses, valid_until)
            VALUES ('$sellerId', '$code', '$discountPct', '$maxUses', '$validUntil')";
    return mysqli_query($conn, $sql);
}

function toggleCoupon($conn, $couponId, $sellerId, $isActive)
{
    $couponId = (int)$couponId;
    $sellerId = (int)$sellerId;
    $isActive = (int)$isActive;
    $sql = "UPDATE coupons SET is_active='$isActive'
            WHERE id='$couponId' AND seller_id='$sellerId'";
    return mysqli_query($conn, $sql);
}

function deleteCoupon($conn, $couponId, $sellerId)
{
    $couponId = (int)$couponId;
    $sellerId = (int)$sellerId;
    $sql = "DELETE FROM coupons WHERE id='$couponId' AND seller_id='$sellerId'";
    return mysqli_query($conn, $sql);
}

function getOrdersBySeller($conn, $sellerId, $statusFilter = '')
{
    $sellerId     = (int)$sellerId;
    $statusFilter = htmlspecialchars(strip_tags(trim($statusFilter)));
    $sql = "SELECT DISTINCT o.id, o.created_at, o.status, o.total_amount, u.name AS customer_name
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN users u ON o.customer_id = u.id
            WHERE oi.seller_id = '$sellerId'";
    if ($statusFilter !== '') {
        $sql .= " AND oi.item_status = '$statusFilter'";
    }
    $sql   .= " ORDER BY o.created_at DESC";
    $result = mysqli_query($conn, $sql);
    $orders = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

function getOrderDetail($conn, $orderId, $sellerId)
{
    $orderId  = (int)$orderId;
    $sellerId = (int)$sellerId;

    $sql1  = "SELECT o.*, u.name AS customer_name, u.email AS customer_email, u.phone AS customer_phone
              FROM orders o
              JOIN users u ON o.customer_id = u.id
              WHERE o.id = '$orderId'";
    $order = mysqli_fetch_assoc(mysqli_query($conn, $sql1));

    $sql2  = "SELECT oi.*, p.name AS product_name, p.primary_image_path
              FROM order_items oi
              JOIN products p ON oi.product_id = p.id
              WHERE oi.order_id = '$orderId' AND oi.seller_id = '$sellerId'";
    $result = mysqli_query($conn, $sql2);
    $items  = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    return array('order' => $order, 'items' => $items);
}

function updateItemStatus($conn, $itemId, $sellerId, $newStatus)
{
    $itemId    = (int)$itemId;
    $sellerId  = (int)$sellerId;
    $newStatus = htmlspecialchars(strip_tags(trim($newStatus)));
    $sql = "UPDATE order_items SET item_status='$newStatus'
            WHERE id='$itemId' AND seller_id='$sellerId'";
    return mysqli_query($conn, $sql);
}

function getReturnRequestsBySeller($conn, $sellerId)
{
    $sellerId = (int)$sellerId;
    $sql = "SELECT rr.*, p.name AS product_name, u.name AS customer_name, o.id AS order_id
            FROM return_requests rr
            JOIN order_items oi ON rr.order_item_id = oi.id
            JOIN products p ON oi.product_id = p.id
            JOIN users u ON rr.customer_id = u.id
            JOIN orders o ON rr.order_id = o.id
            WHERE oi.seller_id = '$sellerId'
            ORDER BY rr.created_at DESC";
    $result   = mysqli_query($conn, $sql);
    $requests = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $requests[] = $row;
    }
    return $requests;
}

function updateReturnStatus($conn, $returnId, $status)
{
    $returnId = (int)$returnId;
    $status   = htmlspecialchars(strip_tags(trim($status)));
    $sql      = "UPDATE return_requests SET status='$status' WHERE id='$returnId'";
    return mysqli_query($conn, $sql);
}

function getReviewsBySeller($conn, $sellerId)
{
    $sellerId = (int)$sellerId;
    $sql = "SELECT r.*, p.name AS product_name, u.name AS customer_name
            FROM reviews r
            JOIN products p ON r.product_id = p.id
            JOIN users u ON r.customer_id = u.id
            WHERE p.seller_id = '$sellerId'
            ORDER BY r.created_at DESC";
    $result  = mysqli_query($conn, $sql);
    $reviews = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
    return $reviews;
}

function replyToReview($conn, $reviewId, $sellerId, $reply)
{
    $reviewId = (int)$reviewId;
    $sellerId = (int)$sellerId;
    $reply    = htmlspecialchars(strip_tags(trim($reply)));
    $sql = "UPDATE reviews SET seller_reply='$reply'
            WHERE id='$reviewId'
            AND product_id IN (SELECT id FROM products WHERE seller_id='$sellerId')";
    return mysqli_query($conn, $sql);
}

function getEarningsSummary($conn, $sellerId, $period = 'month')
{
    $sellerId = (int)$sellerId;
    $interval = ($period === 'week') ? 'INTERVAL 7 DAY' : 'INTERVAL 30 DAY';
    $sql = "SELECT s.commission_rate,
                   COALESCE(SUM(oi.unit_price * oi.quantity), 0) AS gross
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN sellers s ON s.id = oi.seller_id
            WHERE oi.seller_id = '$sellerId'
            AND oi.item_status = 'delivered'
            AND o.created_at >= DATE_SUB(NOW(), $interval)";
    $result = mysqli_query($conn, $sql);
    $row    = mysqli_fetch_assoc($result);
    $gross  = $row['gross'] ?? 0;
    $rate   = $row['commission_rate'] ?? 10;
    $commission = round($gross * $rate / 100, 2);
    return array(
        'gross'           => $gross,
        'commission'      => $commission,
        'net'             => $gross - $commission,
        'commission_rate' => $rate
    );
}

function getTotalRevenue($conn, $sellerId, $period = 'month')
{
    $sellerId = (int)$sellerId;
    $interval = ($period === 'week') ? 'INTERVAL 7 DAY' : 'INTERVAL 30 DAY';
    $sql = "SELECT COALESCE(SUM(oi.unit_price * oi.quantity), 0) AS total
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE oi.seller_id = '$sellerId'
            AND oi.item_status = 'delivered'
            AND o.created_at >= DATE_SUB(NOW(), $interval)";
    $result = mysqli_query($conn, $sql);
    $row    = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function getTopSellingProducts($conn, $sellerId, $limit = 5)
{
    $sellerId = (int)$sellerId;
    $limit    = (int)$limit;
    $sql = "SELECT p.name,
                   SUM(oi.quantity) AS total_qty,
                   SUM(oi.unit_price * oi.quantity) AS total_revenue
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.seller_id = '$sellerId' AND oi.item_status = 'delivered'
            GROUP BY oi.product_id
            ORDER BY total_qty DESC
            LIMIT $limit";
    $result   = mysqli_query($conn, $sql);
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

function getOrderVolumeByDay($conn, $sellerId)
{
    $sellerId = (int)$sellerId;
    $sql = "SELECT DATE(o.created_at) AS day, COUNT(DISTINCT o.id) AS order_count
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            WHERE oi.seller_id = '$sellerId'
            AND o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY DATE(o.created_at)
            ORDER BY day ASC";
    $result = mysqli_query($conn, $sql);
    $data   = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function getAvgOrderValue($conn, $sellerId)
{
    $sellerId = (int)$sellerId;
    $sql = "SELECT COALESCE(AVG(sub.order_total), 0) AS avg_val
            FROM (
                SELECT SUM(oi.unit_price * oi.quantity) AS order_total
                FROM order_items oi
                JOIN orders o ON oi.order_id = o.id
                WHERE oi.seller_id = '$sellerId' AND oi.item_status = 'delivered'
                GROUP BY o.id
            ) sub";
    $result = mysqli_query($conn, $sql);
    $row    = mysqli_fetch_assoc($result);
    return round($row['avg_val'] ?? 0, 2);
}
