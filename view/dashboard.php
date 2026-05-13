
<?php
// views/dashboard.php
$pageTitle  = 'Dashboard';
$activePage = 'dashboard';
require_once __DIR__ . '/partials/header.php';

$lowStock     = $_SESSION['low_stock']     ?? [];
$recentOrders = $_SESSION['recent_orders'] ?? [];
$earnings     = $_SESSION['earnings']      ?? [];
$topProducts  = $_SESSION['top_products']  ?? [];
?>

<div class="page-header">
    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['seller_name'] ?? 'Seller'); ?>!</h1>
    <a href="AnalyticsController.php" class="btn btn-primary">View Analytics</a>
</div>

<!-- KPI Stats -->
<div class="stats-grid">
    <div class="stat-card success">
        <div class="stat-value">৳<?php echo number_format($earnings['gross'] ?? 0, 2); ?></div>
        <div class="stat-label">Gross Revenue (30 days)</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">৳<?php echo number_format($earnings['net'] ?? 0, 2); ?></div>
        <div class="stat-label">Net Payout (after <?php echo $earnings['commission_rate'] ?? 10; ?>% commission)</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo count($recentOrders); ?></div>
        <div class="stat-label">Total Orders</div>
    </div>
    <div class="stat-card <?php echo count($lowStock) > 0 ? 'danger' : 'success'; ?>">
        <div class="stat-value"><?php echo count($lowStock); ?></div>
        <div class="stat-label">Low Stock Alerts</div>
    </div>
</div>

<!-- Low Stock Alert -->
<?php if (!empty($lowStock)): ?>
<div class="card">
    <h2>⚠️ Low Stock Alerts</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Product</th><th>Stock Qty</th><th>Action</th></tr></thead>
            <tbody>
            <?php foreach ($lowStock as $p): ?>
                <tr class="low-stock">
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td><?php echo (int)$p['stock_qty']; ?></td>
                    <td>
                        <a href="ProductController.php?action=edit&id=<?php echo $p['id']; ?>"
                           class="btn btn-warning btn-sm">Update Stock</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Top Products -->
<?php if (!empty($topProducts)): ?>
<div class="card">
    <h2>🏆 Top Selling Products (30 days)</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Product</th><th>Units Sold</th><th>Revenue</th></tr></thead>
            <tbody>
            <?php foreach ($topProducts as $i => $p): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td><?php echo (int)$p['total_qty']; ?></td>
                    <td>৳<?php echo number_format($p['total_revenue'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Recent Orders -->
<div class="card">
    <h2>📦 Recent Orders</h2>
    <?php if (empty($recentOrders)): ?>
        <div class="no-data">No orders yet.</div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Order ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php foreach (array_slice($recentOrders, 0, 10) as $o): ?>
                    <tr>
                        <td><strong>#<?php echo $o['id']; ?></strong></td>
                        <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
                        <td>৳<?php echo number_format($o['total_amount'], 2); ?></td>
                        <td><span class="badge badge-<?php echo $o['status']; ?>"><?php echo ucfirst($o['status']); ?></span></td>
                        <td><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
                        <td>
                            <a href="OrderController.php?action=detail&id=<?php echo $o['id']; ?>"
                               class="btn btn-secondary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
        <a href="OrderController.php?action=index" class="btn btn-primary btn-sm">View All Orders →</a>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>