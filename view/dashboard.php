
<?php

$pageTitle  = ($view ?? '') === 'profile' ? 'My Profile' : 'Dashboard';
$activePage = ($view ?? '') === 'profile' ? 'profile'   : 'dashboard';
include __DIR__ . '/header.php';

if (($view ?? 'dashboard') === 'profile'):
?>

<div class="page-header"><h1>My Profile</h1></div>

<div class="card">
    <h2>Shop &amp; Personal Information</h2>
    <form action="SellerDashboardController.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update_profile">
        <div class="form-row">
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name"
                       value="<?php echo htmlspecialchars($profile['name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone"
                       value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Shop Name *</label>
            <input type="text" name="shop_name"
                   value="<?php echo htmlspecialchars($profile['shop_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Shop Description</label>
            <textarea name="shop_description"><?php echo htmlspecialchars($profile['shop_description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>Address *</label>
            <input type="text" name="address"
                   value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label>Shop Logo</label>
            <?php if (!empty($profile['shop_logo_path'])): ?>
                <br><img src="../<?php echo htmlspecialchars($profile['shop_logo_path']); ?>"
                     style="height:72px;margin-bottom:8px;border-radius:5px;border:1px solid #ddd">
            <?php endif; ?>
            <br>
            <input type="file" name="shop_logo" accept="image/*">
            <small>Leave blank to keep current logo.</small>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<div class="card">
    <h2>Change Password</h2>
    <form action="SellerDashboardController.php" method="post" onsubmit="return checkPassMatch()">
        <input type="hidden" name="action" value="change_password">
        <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>New Password <small>(min 6 chars)</small></label>
                <input type="password" name="new_password" id="newPass" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirmPass" required>
                <span class="err-msg" id="confirmPassErr"></span>
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Change Password</button>
    </form>
</div>

<?php else: ?>


<div class="page-header">
    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['seller_name'] ?? 'Seller'); ?>!</h1>
    <a href="AnalyticsController.php" class="btn btn-primary">View Analytics</a>
</div>

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
        <div class="stat-value"><?php echo count($recentOrders ?? []); ?></div>
        <div class="stat-label">Total Orders</div>
    </div>
    <div class="stat-card <?php echo count($lowStock ?? []) > 0 ? 'danger' : 'success'; ?>">
        <div class="stat-value"><?php echo count($lowStock ?? []); ?></div>
        <div class="stat-label">Low Stock Alerts</div>
    </div>
</div>

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

<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>