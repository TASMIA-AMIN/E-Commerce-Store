<?php

$period       = $period       ?? 'month';
$totalRevenue = $totalRevenue ?? 0;
$topProducts  = $topProducts  ?? [];
$orderVolume  = $orderVolume  ?? [];
$avgOrder     = $avgOrder     ?? 0;
$earnings     = $earnings     ?? [];

$pageTitle  = 'Analytics';
$activePage = 'analytics';
include __DIR__ . '/header.php';
?>

<div class="page-header">
    <h1>Analytics</h1>
    <div style="display:flex;gap:8px">
        <a href="AnalyticsController.php?period=week"
           class="btn btn-sm <?php echo $period === 'week'  ? 'btn-primary' : 'btn-secondary'; ?>">Last 7 Days</a>
        <a href="AnalyticsController.php?period=month"
           class="btn btn-sm <?php echo $period === 'month' ? 'btn-primary' : 'btn-secondary'; ?>">Last 30 Days</a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card success">
        <div class="stat-value">৳<?php echo number_format($totalRevenue, 2); ?></div>
        <div class="stat-label">Gross Revenue</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">৳<?php echo number_format($earnings['net'] ?? 0, 2); ?></div>
        <div class="stat-label">Net Payout (after <?php echo $earnings['commission_rate'] ?? 10; ?>% fee)</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?php echo count($orderVolume); ?></div>
        <div class="stat-label">Active Days</div>
    </div>
    <div class="stat-card">
        <div class="stat-value">৳<?php echo number_format($avgOrder, 2); ?></div>
        <div class="stat-label">Avg Order Value</div>
    </div>
</div>

<?php if (!empty($orderVolume)): ?>
<div class="card">
    <h2>📈 Order Volume (<?php echo $period === 'week' ? 'Last 7 Days' : 'Last 30 Days'; ?>)</h2>
    <div class="chart-box">
        <canvas id="volumeChart"></canvas>
    </div>
    <script>
        var volumeData = <?php echo json_encode($orderVolume); ?>;
    </script>
</div>
<?php endif; ?>

<?php if (!empty($topProducts)): ?>
<div class="card">
    <h2>🏆 Top Selling Products</h2>
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

<?php if (empty($orderVolume) && empty($topProducts)): ?>
<div class="card">
    <div class="no-data">No analytics data available yet. Data appears once orders are delivered.</div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>


