<?php
// views/order.php
// Rendered by OrderController for actions: index | detail

$action = $action ?? 'index';
$orders = $_SESSION['orders']       ?? [];
$filter = $_SESSION['order_filter'] ?? '';
$data   = $_SESSION['order_detail'] ?? [];
$order  = $data['order']            ?? [];
$items  = $data['items']            ?? [];

$pageTitle  = $action === 'detail' ? 'Order #' . ($order['id'] ?? '') : 'Orders';
$activePage = 'orders';
require_once __DIR__ . '/partials/header.php';

$statuses = ['' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
$nextStatus = ['pending' => ['confirmed','Confirm Order'], 'confirmed' => ['shipped','Mark Shipped'], 'shipped' => ['delivered','Mark Delivered']];
?>

<!-- ══════════════════════════════════════════
     INDEX — Order list
══════════════════════════════════════════ -->
<?php if ($action === 'index'): ?>

<div class="page-header"><h1>Incoming Orders</h1></div>

<div class="filter-bar">
    <label>Status:</label>
    <?php foreach ($statuses as $val => $label): ?>
        <a href="OrderController.php?action=index&status=<?php echo $val; ?>"
           class="btn btn-sm <?php echo $filter === $val ? 'btn-primary' : 'btn-secondary'; ?>">
            <?php echo $label; ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="filter-bar">
    <label>Search:</label>
    <input type="text" placeholder="Filter orders…" oninput="tableSearch(this,'orderTable')">
</div>

<div class="card">
    <?php if (empty($orders)): ?>
        <div class="no-data">No orders found.</div>
    <?php else: ?>
    <div class="table-wrap">
        <table id="orderTable">
            <thead>
                <tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $o): ?>
                <tr>
                    <td><strong>#<?php echo $o['id']; ?></strong></td>
                    <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
                    <td>৳<?php echo number_format($o['total_amount'], 2); ?></td>
                    <td><span class="badge badge-<?php echo $o['status']; ?>"><?php echo ucfirst($o['status']); ?></span></td>
                    <td><?php echo date('d M Y, h:i A', strtotime($o['created_at'])); ?></td>
                    <td>
                        <a href="OrderController.php?action=detail&id=<?php echo $o['id']; ?>"
                           class="btn btn-primary btn-sm">View Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<!-- ══════════════════════════════════════════
     DETAIL — Single order
══════════════════════════════════════════ -->
<?php elseif ($action === 'detail'): ?>

<div class="page-header">
    <h1>Order #<?php echo (int)$order['id']; ?></h1>
    <a href="OrderController.php?action=index" class="btn btn-secondary">← Back to Orders</a>
</div>

<div class="card">
    <h2>Order Information</h2>
    <div class="form-row">
        <div class="form-group" style="flex:1.2">
            <div class="section-title">Customer</div>
            <p><?php echo htmlspecialchars($order['customer_name']); ?></p>
            <p><?php echo htmlspecialchars($order['customer_email']); ?></p>
            <p><?php echo htmlspecialchars($order['customer_phone'] ?? '—'); ?></p>
        </div>
        <div class="form-group" style="flex:1.5">
            <div class="section-title">Shipping</div>
            <p><?php echo htmlspecialchars($order['shipping_address']); ?></p>
            <p>Payment: <strong><?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?></strong></p>
            <p>Date: <?php echo date('d M Y, h:i A', strtotime($order['created_at'])); ?></p>
        </div>
        <div class="form-group">
            <div class="section-title">Totals</div>
            <p>Subtotal: ৳<?php echo number_format($order['subtotal'], 2); ?></p>
            <p>Discount: ৳<?php echo number_format($order['discount_amount'], 2); ?></p>
            <p><strong>Total: ৳<?php echo number_format($order['total_amount'], 2); ?></strong></p>
            <p>Status: <span class="badge badge-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></p>
        </div>
    </div>
</div>

<div class="card">
    <h2>Your Items in This Order</h2>
    <?php if (empty($items)): ?>
        <div class="no-data">No items from your shop in this order.</div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Image</th><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th><th>Status</th><th>Update</th></tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <?php if (!empty($item['primary_image_path'])): ?>
                            <img src="../<?php echo htmlspecialchars($item['primary_image_path']); ?>" class="thumb" alt="">
                        <?php else: ?><div class="thumb-placeholder">No img</div><?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo (int)$item['quantity']; ?></td>
                    <td>৳<?php echo number_format($item['unit_price'], 2); ?></td>
                    <td>৳<?php echo number_format($item['unit_price'] * $item['quantity'], 2); ?></td>
                    <td><span class="badge badge-<?php echo $item['item_status']; ?>"><?php echo ucfirst($item['item_status']); ?></span></td>
                    <td>
                        <?php if (isset($nextStatus[$item['item_status']])): ?>
                            <?php [$ns, $label] = $nextStatus[$item['item_status']]; ?>
                            <form class="inline-form" action="OrderController.php?action=update_status" method="post">
                                <input type="hidden" name="item_id"    value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="order_id"   value="<?php echo $order['id']; ?>">
                                <input type="hidden" name="new_status" value="<?php echo $ns; ?>">
                                <button type="submit" class="btn btn-success btn-sm"><?php echo $label; ?></button>
                            </form>
                        <?php else: ?><span style="color:#aaa">—</span><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/partials/footer.php'; ?>