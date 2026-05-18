<?php

$reviews    = $reviews ?? [];
$pageTitle  = 'Product Reviews';
$activePage = 'review';
include __DIR__ . '/header.php';

$count       = count($reviews);
$totalRating = 0;
foreach ($reviews as $r) { $totalRating += $r['rating']; }
$avgRating = $count > 0 ? round($totalRating / $count, 1) : 0;
?>

<div class="page-header">
    <h1>Product Reviews</h1>
    <?php if ($count > 0): ?>
        <div style="font-size:1rem;color:#555">
            <span class="stars"><?php echo str_repeat('★', round($avgRating)); ?></span>
            <strong><?php echo $avgRating; ?></strong> avg · <?php echo $count; ?> review<?php echo $count !== 1 ? 's' : ''; ?>
        </div>
    <?php endif; ?>
</div>

<?php if (empty($reviews)): ?>
    <div class="card">
        <div class="no-data">No reviews yet. Reviews appear here once customers leave feedback.</div>
    </div>
<?php else: ?>
    <?php foreach ($reviews as $r): ?>
    <div class="review-card">
        <div class="review-header">
            <strong><?php echo htmlspecialchars($r['product_name']); ?></strong>
            <span class="stars">
                <?php echo str_repeat('★', $r['rating']); ?>
                <span class="stars-empty"><?php echo str_repeat('★', 5 - $r['rating']); ?></span>
            </span>
        </div>
        <div class="review-meta">
            <?php echo htmlspecialchars($r['customer_name']); ?> &nbsp;·&nbsp; <?php echo date('d M Y', strtotime($r['created_at'])); ?>
        </div>
        <div class="review-body"><?php echo htmlspecialchars($r['review_text'] ?? ''); ?></div>

        <?php if (!empty($r['seller_reply'])): ?>
            <div class="seller-reply">
                <strong>Your Reply</strong>
                <?php echo htmlspecialchars($r['seller_reply']); ?>
            </div>
        <?php else: ?>
            <form class="reply-form" action="ReviewController.php?action=reply_save" method="post"
                  onsubmit="return validateReply(this)">
                <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">
                <textarea name="reply" placeholder="Write a public reply…" required></textarea>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">Post Reply</button>
                    <span class="err-msg reply-err" style="display:block;margin-top:4px"></span>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>