<?php

$coupons    = $coupons ?? [];
$pageTitle  = 'Coupons';
$activePage = 'coupon';
include __DIR__ . '/header.php';
?>

<div class="page-header"><h1>Promotional Coupons</h1></div>

<div class="card">
    <h2>Create New Coupon</h2>
    <form action="CouponController.php?action=save" method="post"
          onsubmit="return validateCoupon(this)" novalidate>
        <div class="form-row">
            <div class="form-group">
                <label>Coupon Code *</label>
                <input type="text" name="code" id="couponCode" placeholder="e.g. SAVE20" autocomplete="off">
                <span class="err-msg" id="couponCodeErr"></span>
            </div>
            <div class="form-group">
                <label>Discount % *</label>
                <input type="number" name="discount_pct" id="discPct" min="1" max="100" step="0.01">
                <span class="err-msg" id="discPctErr"></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Max Uses *</label>
                <input type="number" name="max_uses" id="maxUses" min="1" value="100">
                <span class="err-msg" id="maxUsesErr"></span>
            </div>
            <div class="form-group">
                <label>Valid Until *</label>
                <input type="date" name="valid_until" id="validUntil" min="<?php echo date('Y-m-d'); ?>">
                <span class="err-msg" id="validUntilErr"></span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create Coupon</button>
    </form>
</div>

<div class="card">
    <h2>My Coupons</h2>
    <?php if (empty($coupons)): ?>
        <div class="no-data">No coupons yet.</div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Code</th><th>Discount</th><th>Uses</th><th>Valid Until</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($coupons as $c): ?>
                <?php $expired = strtotime($c['valid_until']) < strtotime('today'); ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($c['code']); ?></strong></td>
                    <td><?php echo $c['discount_pct']; ?>%</td>
                    <td><?php echo (int)$c['uses_count']; ?> / <?php echo (int)$c['max_uses']; ?></td>
                    <td>
                        <?php echo $c['valid_until']; ?>
                        <?php if ($expired): ?><span class="badge badge-cancelled" style="margin-left:4px">Expired</span><?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo $c['is_active'] ? 'active' : 'inactive'; ?>">
                            <?php echo $c['is_active'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td>
                        <form class="inline-form" action="CouponController.php?action=toggle" method="post">
                            <input type="hidden" name="coupon_id" value="<?php echo $c['id']; ?>">
                            <input type="hidden" name="is_active"  value="<?php echo $c['is_active'] ? 0 : 1; ?>">
                            <button type="submit" class="btn btn-sm <?php echo $c['is_active'] ? 'btn-secondary' : 'btn-success'; ?>">
                                <?php echo $c['is_active'] ? 'Deactivate' : 'Activate'; ?>
                            </button>
                        </form>
                        <form class="inline-form" action="CouponController.php?action=delete" method="post"
                              onsubmit="return confirmDelete('Delete coupon <?php echo htmlspecialchars($c['code']); ?>?')">
                            <input type="hidden" name="coupon_id" value="<?php echo $c['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>