<?php
// controllers/ProductController.php
// Actions: (none)=list | create | save | edit | update | toggle | delete | low_stock_ajax

require_once 'auth_guard.php';
require_once '../models/Connect.php';
require_once '../models/SellerModel.php';
require_once '../models/Close.php';

$action    = $_POST['action'] ?? $_GET['action'] ?? '';
$sellerId  = $_SESSION['seller_id'];

// ── SAVE (create new) ────────────────────────────────────────
if ($action === 'save') {
    $name        = htmlspecialchars(trim($_POST['name']        ?? ''));
    $description = htmlspecialchars(trim($_POST['description'] ?? ''));
    $price       = $_POST['price']       ?? '';
    $stockQty    = $_POST['stock_qty']   ?? '';
    $categoryId  = $_POST['category_id'] ?? '';

    if (!$name || !$price || !$stockQty || !$categoryId) {
        $_SESSION['error'] = 'Name, price, stock, and category are required.';
        header('Location: ProductController.php?action=create'); exit;
    }

    $primaryImagePath = '';
    if (isset($_FILES['primary_image']) && $_FILES['primary_image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['primary_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $filename = uniqid('prod_', true) . '.' . $ext;
            move_uploaded_file($_FILES['primary_image']['tmp_name'], '../uploads/product_images/' . $filename);
            $primaryImagePath = 'uploads/product_images/' . $filename;
        }
    }

    $conn      = connect();
    $productId = createProduct($conn, $sellerId, (int)$categoryId, $name, $description, (float)$price, (int)$stockQty, $primaryImagePath);

    if (isset($_FILES['additional_images'])) {
        $order = 1; $count = 0;
        foreach ($_FILES['additional_images']['tmp_name'] as $i => $tmpName) {
            if ($count >= 4 || $_FILES['additional_images']['error'][$i] !== UPLOAD_ERR_OK) continue;
            $ext = strtolower(pathinfo($_FILES['additional_images']['name'][$i], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $filename = uniqid('pimg_', true) . '.' . $ext;
                move_uploaded_file($tmpName, '../uploads/product_images/' . $filename);
                addProductImage($conn, $productId, 'uploads/product_images/' . $filename, $order++);
                $count++;
            }
        }
    }

    close($conn);
    $_SESSION['msg'] = 'Product created successfully.';
    header('Location: ProductController.php'); exit;
}

// ── UPDATE (edit existing) ───────────────────────────────────
if ($action === 'update') {
    $productId   = (int)($_POST['product_id'] ?? 0);
    $name        = htmlspecialchars(trim($_POST['name']        ?? ''));
    $description = htmlspecialchars(trim($_POST['description'] ?? ''));
    $price       = $_POST['price']       ?? '';
    $stockQty    = $_POST['stock_qty']   ?? '';
    $categoryId  = $_POST['category_id'] ?? '';

    if (!$productId || !$name || !$price || !$stockQty || !$categoryId) {
        $_SESSION['error'] = 'All required fields must be filled.';
        header('Location: ProductController.php?action=edit&id=' . $productId); exit;
    }

    $conn    = connect();
    $product = getProductById($conn, $productId, $sellerId);
    if (!$product) { close($conn); header('Location: ProductController.php'); exit; }

    $primaryImagePath = $product['primary_image_path'];
    if (isset($_FILES['primary_image']) && $_FILES['primary_image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['primary_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $filename = uniqid('prod_', true) . '.' . $ext;
            move_uploaded_file($_FILES['primary_image']['tmp_name'], '../uploads/product_images/' . $filename);
            $primaryImagePath = 'uploads/product_images/' . $filename;
        }
    }

    updateProduct($conn, $productId, $sellerId, (int)$categoryId, $name, $description, (float)$price, (int)$stockQty, $primaryImagePath);
    close($conn);

    $_SESSION['msg'] = 'Product updated successfully.';
    header('Location: ProductController.php'); exit;
}

// ── TOGGLE availability ──────────────────────────────────────
if ($action === 'toggle') {
    $productId   = (int)($_POST['product_id']  ?? 0);
    $isAvailable = (int)($_POST['is_available'] ?? 0);
    if ($productId) {
        $conn = connect();
        toggleProductAvailability($conn, $productId, $sellerId, $isAvailable);
        close($conn);
        $_SESSION['msg'] = 'Product availability updated.';
    }
    header('Location: ProductController.php'); exit;
}

// ── DELETE ───────────────────────────────────────────────────
if ($action === 'delete') {
    $productId = (int)($_POST['product_id'] ?? 0);
    if ($productId) {
        $conn = connect();
        if (productHasPendingOrders($conn, $productId)) {
            $_SESSION['error'] = 'Cannot delete a product with active orders.';
        } else {
            deleteProduct($conn, $productId, $sellerId);
            $_SESSION['msg'] = 'Product deleted.';
        }
        close($conn);
    }
    header('Location: ProductController.php'); exit;
}

// ── AJAX: low stock JSON ─────────────────────────────────────
if ($action === 'low_stock_ajax') {
    $threshold = (int)($_GET['threshold'] ?? 5);
    $conn      = connect();
    $products  = getLowStockProducts($conn, $sellerId, $threshold);
    close($conn);
    header('Content-Type: application/json');
    echo json_encode($products);
    exit;
}

// ── LOAD DATA & SHOW VIEW ────────────────────────────────────
$conn = connect();

if ($action === 'create') {
    $data = ['categories' => getAllCategories($conn)];
} elseif ($action === 'edit') {
    $id      = (int)($_GET['id'] ?? 0);
    $product = getProductById($conn, $id, $sellerId);
    if (!$product) { close($conn); header('Location: ProductController.php'); exit; }
    $data = [
        'product'    => $product,
        'images'     => getProductImages($conn, $id),
        'categories' => getAllCategories($conn),
    ];
} else {
    $data = [
        'products'  => getProductsBySeller($conn, $sellerId),
        'low_stock' => getLowStockProducts($conn, $sellerId, 5),
    ];
    $action = 'list';
}

close($conn);
require_once '../views/product.php';