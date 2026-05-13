<?php

function getSellerByEmail($email)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT u.*, s.id AS seller_id, s.is_approved
            FROM users u JOIN sellers s ON u.id = s.user_id
            WHERE u.email = '$email' AND u.role = 'seller'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row;
}

function registerSellerUser($name, $email, $passwordHash, $phone)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "INSERT INTO users (name, email, password_hash, phone, role)
            VALUES ('$name', '$email', '$passwordHash', '$phone', 'seller')";
    mysqli_query($conn, $sql);
    $id = mysqli_insert_id($conn);
    mysqli_close($conn);
    return $id;
}

function registerSellerProfile($userId, $shopName, $shopDesc, $address, $logoPath)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "INSERT INTO sellers (user_id, shop_name, shop_description, address, shop_logo_path)
            VALUES ('$userId', '$shopName', '$shopDesc', '$address', '$logoPath')";
    mysqli_query($conn, $sql);
    $id = mysqli_insert_id($conn);
    mysqli_close($conn);
    return $id;
}

function emailExists($email)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $exists = mysqli_num_rows($result) > 0;
    mysqli_close($conn);
    return $exists;
}

function getSellerProfile($sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT s.*, u.name, u.email, u.phone, u.profile_pic
            FROM sellers s JOIN users u ON s.user_id = u.id
            WHERE s.id = '$sellerId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row;
}

function updateSellerProfile($sellerId, $shopName, $shopDesc, $address, $logoPath, $name, $phone, $userId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql1 = "UPDATE sellers SET shop_name='$shopName', shop_description='$shopDesc',
             address='$address', shop_logo_path='$logoPath' WHERE id='$sellerId'";
    mysqli_query($conn, $sql1);

    $sql2 = "UPDATE users SET name='$name', phone='$phone' WHERE id='$userId'";
    $flag = mysqli_query($conn, $sql2);
    mysqli_close($conn);
    return $flag;
}

function changeSellerPassword($userId, $newHash)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE users SET password_hash='$newHash' WHERE id='$userId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function getAllCategories()
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT c.id, c.name, p.name AS parent_name FROM categories c
            LEFT JOIN categories p ON c.parent_id = p.id
            ORDER BY p.name, c.name";
    $result = mysqli_query($conn, $sql);
    $cats = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $cats[] = $row;
    }
    mysqli_close($conn);
    return $cats;
}

function getProductsBySeller($sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT p.*, c.name AS category_name FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.seller_id = '$sellerId' ORDER BY p.created_at DESC";
    $result = mysqli_query($conn, $sql);
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    mysqli_close($conn);
    return $products;
}

function getLowStockProducts($sellerId, $threshold = 5)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT id, name, stock_qty FROM products
            WHERE seller_id = '$sellerId' AND stock_qty <= '$threshold' AND is_available = 1";
    $result = mysqli_query($conn, $sql);
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    mysqli_close($conn);
    return $products;
}

function getProductById($productId, $sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT p.*, c.name AS category_name FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.id = '$productId' AND p.seller_id = '$sellerId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row;
}

function getProductImages($productId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT * FROM product_images WHERE product_id = '$productId' ORDER BY display_order";
    $result = mysqli_query($conn, $sql);
    $imgs = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $imgs[] = $row;
    }
    mysqli_close($conn);
    return $imgs;
}

function createProduct($sellerId, $categoryId, $name, $description, $price, $stockQty, $primaryImagePath)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "INSERT INTO products (seller_id, category_id, name, description, price, stock_qty, primary_image_path)
            VALUES ('$sellerId', '$categoryId', '$name', '$description', '$price', '$stockQty', '$primaryImagePath')";
    mysqli_query($conn, $sql);
    $id = mysqli_insert_id($conn);
    mysqli_close($conn);
    return $id;
}

function addProductImage($productId, $imagePath, $order)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "INSERT INTO product_images (product_id, image_path, display_order)
            VALUES ('$productId', '$imagePath', '$order')";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function updateProduct($productId, $sellerId, $categoryId, $name, $description, $price, $stockQty, $primaryImagePath)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE products SET category_id='$categoryId', name='$name', description='$description',
            price='$price', stock_qty='$stockQty', primary_image_path='$primaryImagePath'
            WHERE id='$productId' AND seller_id='$sellerId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function toggleProductAvailability($productId, $sellerId, $isAvailable)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE products SET is_available='$isAvailable'
            WHERE id='$productId' AND seller_id='$sellerId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function productHasPendingOrders($productId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT id FROM order_items WHERE product_id = '$productId'
            AND item_status IN ('pending','confirmed','shipped')";
    $result = mysqli_query($conn, $sql);
    $has = mysqli_num_rows($result) > 0;
    mysqli_close($conn);
    return $has;
}

function deleteProduct($productId, $sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "DELETE FROM products WHERE id='$productId' AND seller_id='$sellerId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function updateStockQty($productId, $sellerId, $qty)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE products SET stock_qty='$qty'
            WHERE id='$productId' AND seller_id='$sellerId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function getCouponsBySeller($sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT * FROM coupons WHERE seller_id='$sellerId' ORDER BY valid_until DESC";
    $result = mysqli_query($conn, $sql);
    $coupons = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $coupons[] = $row;
    }
    mysqli_close($conn);
    return $coupons;
}

function createCoupon($sellerId, $code, $discountPct, $maxUses, $validUntil)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "INSERT INTO coupons (seller_id, code, discount_pct, max_uses, valid_until)
            VALUES ('$sellerId', '$code', '$discountPct', '$maxUses', '$validUntil')";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function toggleCoupon($couponId, $sellerId, $isActive)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE coupons SET is_active='$isActive'
            WHERE id='$couponId' AND seller_id='$sellerId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function deleteCoupon($couponId, $sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "DELETE FROM coupons WHERE id='$couponId' AND seller_id='$sellerId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function getOrdersBySeller($sellerId, $statusFilter = '')
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT DISTINCT o.id, o.created_at, o.status, o.total_amount, u.name AS customer_name
            FROM orders o JOIN order_items oi ON o.id = oi.order_id
            JOIN users u ON o.customer_id = u.id
            WHERE oi.seller_id = '$sellerId'";
    if ($statusFilter !== '') {
        $sql .= " AND oi.item_status = '$statusFilter'";
    }
    $sql .= " ORDER BY o.created_at DESC";

    $result = mysqli_query($conn, $sql);
    $orders = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    mysqli_close($conn);
    return $orders;
}

function getOrderDetail($orderId, $sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql1 = "SELECT o.*, u.name AS customer_name, u.email AS customer_email, u.phone AS customer_phone
             FROM orders o JOIN users u ON o.customer_id = u.id WHERE o.id = '$orderId'";
    $order = mysqli_fetch_assoc(mysqli_query($conn, $sql1));

    $sql2 = "SELECT oi.*, p.name AS product_name, p.primary_image_path
             FROM order_items oi JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id = '$orderId' AND oi.seller_id = '$sellerId'";
    $result = mysqli_query($conn, $sql2);
    $items = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    mysqli_close($conn);
    return array("order" => $order, "items" => $items);
}

function updateItemStatus($itemId, $sellerId, $newStatus)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE order_items SET item_status='$newStatus'
            WHERE id='$itemId' AND seller_id='$sellerId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function getReturnRequestsBySeller($sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT rr.*, p.name AS product_name, u.name AS customer_name, o.id AS order_id
            FROM return_requests rr JOIN order_items oi ON rr.order_item_id = oi.id
            JOIN products p ON oi.product_id = p.id
            JOIN users u ON rr.customer_id = u.id
            JOIN orders o ON rr.order_id = o.id
            WHERE oi.seller_id = '$sellerId' ORDER BY rr.created_at DESC";
    $result = mysqli_query($conn, $sql);
    $requests = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $requests[] = $row;
    }
    mysqli_close($conn);
    return $requests;
}

function updateReturnStatus($returnId, $status)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE return_requests SET status='$status' WHERE id='$returnId'";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function getReviewsBySeller($sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT r.*, p.name AS product_name, u.name AS customer_name
            FROM reviews r JOIN products p ON r.product_id = p.id
            JOIN users u ON r.customer_id = u.id
            WHERE p.seller_id = '$sellerId' ORDER BY r.created_at DESC";
    $result = mysqli_query($conn, $sql);
    $reviews = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
    mysqli_close($conn);
    return $reviews;
}

function replyToReview($reviewId, $sellerId, $reply)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "UPDATE reviews SET seller_reply='$reply' WHERE id='$reviewId'
            AND product_id IN (SELECT id FROM products WHERE seller_id='$sellerId')";
    $flag = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $flag;
}

function getTotalRevenue($sellerId, $period = 'month')
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $interval = ($period === 'week') ? 'INTERVAL 7 DAY' : 'INTERVAL 30 DAY';
    $sql = "SELECT COALESCE(SUM(oi.unit_price * oi.quantity), 0) AS total
            FROM order_items oi JOIN orders o ON oi.order_id = o.id
            WHERE oi.seller_id = '$sellerId' AND oi.item_status = 'delivered'
            AND o.created_at >= DATE_SUB(NOW(), $interval)";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'];
}

function getTopSellingProducts($sellerId, $limit = 5)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT p.name, SUM(oi.quantity) AS total_qty, SUM(oi.unit_price * oi.quantity) AS total_revenue
            FROM order_items oi JOIN products p ON oi.product_id = p.id
            WHERE oi.seller_id = '$sellerId' AND oi.item_status = 'delivered'
            GROUP BY oi.product_id ORDER BY total_qty DESC LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    mysqli_close($conn);
    return $products;
}

function getOrderVolumeByDay($sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT DATE(o.created_at) AS day, COUNT(DISTINCT o.id) AS order_count
            FROM orders o JOIN order_items oi ON o.id = oi.order_id
            WHERE oi.seller_id = '$sellerId'
            AND o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY DATE(o.created_at) ORDER BY day ASC";
    $result = mysqli_query($conn, $sql);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($conn);
    return $data;
}

function getEarningsSummary($sellerId, $period = 'month')
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $interval = ($period === 'week') ? 'INTERVAL 7 DAY' : 'INTERVAL 30 DAY';
    $sql = "SELECT s.commission_rate, COALESCE(SUM(oi.unit_price * oi.quantity), 0) AS gross
            FROM order_items oi JOIN orders o ON oi.order_id = o.id
            JOIN sellers s ON s.id = oi.seller_id
            WHERE oi.seller_id = '$sellerId' AND oi.item_status = 'delivered'
            AND o.created_at >= DATE_SUB(NOW(), $interval)";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);

    $gross = $row['gross'];
    $rate  = $row['commission_rate'] ?? 10;
    $commission = round($gross * $rate / 100, 2);
    return array("gross" => $gross, "commission" => $commission, "net" => $gross - $commission, "commission_rate" => $rate);
}

function getAvgOrderValue($sellerId)
{
    $conn = mysqli_connect("localhost", "root", "root", "ecommerce");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

    $sql = "SELECT COALESCE(AVG(sub.order_total), 0) AS avg_val
            FROM (SELECT SUM(oi.unit_price * oi.quantity) AS order_total
                  FROM order_items oi JOIN orders o ON oi.order_id = o.id
                  WHERE oi.seller_id = '$sellerId' AND oi.item_status = 'delivered'
                  GROUP BY o.id) sub";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return round($row['avg_val'], 2);
}

function getLowStockJSON($sellerId, $threshold = 5)
{
    $products = getLowStockProducts($sellerId, $threshold);
    return json_encode($products);
}