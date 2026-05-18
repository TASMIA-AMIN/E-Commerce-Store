<?php

$action     = $action     ?? 'list';
$products   = $products   ?? [];
$lowStock   = $lowStock   ?? [];
$categories = $categories ?? [];
$product    = $product    ?? [];
$images     = $images     ?? [];

$pageTitle  = $action === 'create' ? 'Add Product' : ($action === 'edit' ? 'Edit Product' : 'My Products');
$activePage = 'product';
include __DIR__ . '/header.php';
?>

<?php if ($action === 'list'): ?>

<div class="page-header">
    <h1>My Products</h1>
    <div style="display:flex;gap:8px">
        <button class="btn btn-outline btn-sm" onclick="loadLowStock()">🔔 Refresh Low Stock</button>
        <a href="ProductController.php?action=create" class="btn btn-primary">+ Add Product</a>
    </div>
</div>

<div id="lowStockPanel">
<?php if (!empty($lowStock)): ?>
    <div class="alert alert-warning">
        ⚠️ <strong><?php echo count($lowStock); ?></strong> product(s) low on stock (≤ 5 units).
        <ul>
        <?php foreach ($lowStock as $p): ?>
            <li><?php echo htmlspecialchars($p['name']); ?> — <strong><?php echo (int)$p['stock_qty']; ?></strong> left</li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
</div>

<div class="filter-bar">
    <label>Search:</label>
    <input type="text" placeholder="Filter products…" oninput="tableSearch(this,'productTable')">
</div>

<div class="card">
    <div class="table-wrap">
        <table id="productTable">
            <thead>
                <tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Available</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="7">
                    <div class="no-data">No products yet. <a href="ProductController.php?action=create">Add your first product!</a></div>
                </td></tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                <tr class="<?php echo $p['stock_qty'] <= 5 ? 'low-stock' : ''; ?>">
                    <td>
                        <?php if (!empty($p['primary_image_path'])): ?>
                            <img src="../<?php echo htmlspecialchars($p['primary_image_path']); ?>" class="thumb" alt="">
                        <?php else: ?><div class="thumb-placeholder">No img</div><?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td><?php echo htmlspecialchars($p['category_name']); ?></td>
                    <td>৳<?php echo number_format($p['price'], 2); ?></td>
                    <td><?php echo (int)$p['stock_qty']; ?></td>
                    <td>
                        <form class="inline-form" action="ProductController.php?action=toggle" method="post">
                            <input type="hidden" name="product_id"   value="<?php echo $p['id']; ?>">
                            <input type="hidden" name="is_available" value="<?php echo $p['is_available'] ? 0 : 1; ?>">
                            <button type="submit" class="btn btn-sm <?php echo $p['is_available'] ? 'btn-success' : 'btn-secondary'; ?>">
                                <?php echo $p['is_available'] ? 'Active' : 'Inactive'; ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="ProductController.php?action=edit&id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form class="inline-form" action="ProductController.php?action=delete" method="post"
                              onsubmit="return confirmDelete('Delete this product permanently?')">
                            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php elseif ($action === 'create'): ?>

<div class="page-header">
    <h1>Add New Product</h1>
    <a href="ProductController.php" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <form action="ProductController.php?action=save" method="post"
          enctype="multipart/form-data" onsubmit="return validateProduct(this)" novalidate>

        <div class="form-row">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" id="name" placeholder="Enter product name">
                <span class="err-msg" id="pNameErr"></span>
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category_id" id="category_id">
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?php echo $c['id']; ?>">
                            <?php echo $c['parent_name']
                                ? htmlspecialchars($c['parent_name'] . ' › ' . $c['name'])
                                : htmlspecialchars($c['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="err-msg" id="pCatErr"></span>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" placeholder="Describe your product…"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Price (৳) *</label>
                <input type="number" name="price" id="price" min="0" step="0.01" placeholder="0.00">
                <span class="err-msg" id="pPriceErr"></span>
            </div>
            <div class="form-group">
                <label>Stock Quantity *</label>
                <input type="number" name="stock_qty" id="stock_qty" min="0" placeholder="0">
                <span class="err-msg" id="pStockErr"></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Primary Image</label>
                <input type="file" name="primary_image" id="primaryImageInput" accept="image/*">
                <img id="primaryImagePreview" src="#" alt=""
                     style="display:none;margin-top:8px;height:90px;border-radius:5px;border:1px solid #ddd">
            </div>
            <div class="form-group">
                <label>Additional Images <small>(up to 4)</small></label>
                <input type="file" name="additional_images[]" accept="image/*" multiple>
            </div>
        </div>
        <div style="display:flex;gap:10px">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="ProductController.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php elseif ($action === 'edit'): ?>
<!-- ══════════════════════════════════════════
     EDIT
══════════════════════════════════════════ -->
<div class="page-header">
    <h1>Edit: <?php echo htmlspecialchars($product['name'] ?? ''); ?></h1>
    <a href="ProductController.php" class="btn btn-secondary">← Back</a>
</div>

<div class="card">
    <form action="ProductController.php?action=update" method="post"
          enctype="multipart/form-data" onsubmit="return validateProduct(this)" novalidate>
        <input type="hidden" name="product_id" value="<?php echo (int)$product['id']; ?>">

        <div class="form-row">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name"
                       value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
                <span class="err-msg" id="pNameErr"></span>
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category_id" required>
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?php echo $c['id']; ?>"
                            <?php echo $c['id'] == ($product['category_id'] ?? '') ? 'selected' : ''; ?>>
                            <?php echo $c['parent_name']
                                ? htmlspecialchars($c['parent_name'] . ' › ' . $c['name'])
                                : htmlspecialchars($c['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="err-msg" id="pCatErr"></span>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Price (৳) *</label>
                <input type="number" name="price" min="0" step="0.01"
                       value="<?php echo $product['price'] ?? 0; ?>" required>
                <span class="err-msg" id="pPriceErr"></span>
            </div>
            <div class="form-group">
                <label>Stock Quantity *</label>
                <input type="number" name="stock_qty" min="0"
                       value="<?php echo $product['stock_qty'] ?? 0; ?>" required>
                <span class="err-msg" id="pStockErr"></span>
            </div>
        </div>
        <div class="form-group">
            <label>Primary Image</label>
            <?php if (!empty($product['primary_image_path'])): ?>
                <br><img src="../<?php echo htmlspecialchars($product['primary_image_path']); ?>"
                     style="height:90px;margin-bottom:8px;border-radius:5px;border:1px solid #ddd">
            <?php endif; ?>
            <br><input type="file" name="primary_image" id="primaryImageInput" accept="image/*">
            <small>Leave blank to keep current image.</small>
        </div>
        <?php if (!empty($images)): ?>
        <div class="form-group">
            <label>Existing Additional Images</label><br>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:6px">
                <?php foreach ($images as $img): ?>
                    <img src="../<?php echo htmlspecialchars($img['image_path']); ?>" class="thumb" alt="">
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <div style="display:flex;gap:10px">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="ProductController.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>