<?php
// views/return.php
$pageTitle  = 'Return Requests';
$activePage = 'returns';
require_once __DIR__ . '/partials/header.php';

$requests = $_SESSION['return_requests'] ?? [];
?>

<div class="page-header"><h1>Return Requests</h1></div>

<div class="card">
    <?php if (empty($requests)): ?>
        <div class="no-data">No return requests at the moment.</div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Order</th><th>Product</th><th>Customer</th><th>Reason</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td>#<?php echo $r['id']; ?></td>
                    <td>
                        <a href="OrderController.php?action=detail&id=<?php echo $r['order_id']; ?>">
                            #<?php echo $r['order_id']; ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($r['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($r['customer_name']); ?></td>
                    <td style="max-width:180px;word-break:break-word"><?php echo htmlspecialchars($r['reason'] ?? '—'); ?></td>
                    <td><span class="badge badge-<?php echo $r['status']; ?>"><?php echo ucfirst($r['status']); ?></span></td>
                    <td><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
                    <td>
                        <?php if ($r['status'] === 'pending'): ?>
                            <form class="inline-form" action="ReturnController.php?action=update" method="post">
                                <input type="hidden" name="return_id" value="<?php echo $r['id']; ?>">
                                <input type="hidden" name="status"    value="approved">
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form class="inline-form" action="ReturnController.php?action=update" method="post"
                                  onsubmit="return confirmDelete('Reject this return?')">
                                <input type="hidden" name="return_id" value="<?php echo $r['id']; ?>">
                                <input type="hidden" name="status"    value="rejected">
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        <?php elseif ($r['status'] === 'approved'): ?>
                            <form class="inline-form" action="ReturnController.php?action=update" method="post">
                                <input type="hidden" name="return_id" value="<?php echo $r['id']; ?>">
                                <input type="hidden" name="status"    value="completed">
                                <button type="submit" class="btn btn-primary btn-sm">Mark Completed</button>
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

<?php require_once __DIR__ . '/partials/footer.php'; ?>