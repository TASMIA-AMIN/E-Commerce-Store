// views/js/seller.js
// Client-side validation + AJAX for the Seller role

// ============================================================
// LOGIN VALIDATION
// ============================================================
function validateLogin(form) {
    let valid = true;
    clearErrors(['emailErr', 'passErr']);

    if (!form.email.value.trim()) {
        showError('emailErr', 'Email is required.');
        valid = false;
    }
    if (!form.password.value) {
        showError('passErr', 'Password is required.');
        valid = false;
    }
    return valid;
}

// ============================================================
// REGISTER VALIDATION
// ============================================================
function validateRegister(form) {
    let valid = true;
    clearErrors(['nameErr', 'emailErr', 'passErr', 'confirmErr', 'shopErr', 'addrErr']);

    if (!form.name.value.trim()) {
        showError('nameErr', 'Full name is required.');
        valid = false;
    }
    if (!form.email.value.trim() || !isValidEmail(form.email.value)) {
        showError('emailErr', 'A valid email is required.');
        valid = false;
    }
    if (form.password.value.length < 6) {
        showError('passErr', 'Password must be at least 6 characters.');
        valid = false;
    }
    if (form.password.value !== form.confirm_password.value) {
        showError('confirmErr', 'Passwords do not match.');
        valid = false;
    }
    if (!form.shop_name.value.trim()) {
        showError('shopErr', 'Shop name is required.');
        valid = false;
    }
    if (!form.address.value.trim()) {
        showError('addrErr', 'Address is required.');
        valid = false;
    }
    return valid;
}

// ============================================================
// PRODUCT VALIDATION
// ============================================================
function validateProduct(form) {
    let valid = true;
    clearErrors(['pNameErr', 'pCatErr', 'pPriceErr', 'pStockErr']);

    if (!form.name.value.trim()) {
        showError('pNameErr', 'Product name is required.');
        valid = false;
    }
    if (!form.category_id.value) {
        showError('pCatErr', 'Please select a category.');
        valid = false;
    }
    const price = parseFloat(form.price.value);
    if (isNaN(price) || price < 0) {
        showError('pPriceErr', 'Enter a valid price (≥ 0).');
        valid = false;
    }
    const stock = parseInt(form.stock_qty.value);
    if (isNaN(stock) || stock < 0) {
        showError('pStockErr', 'Enter a valid stock quantity (≥ 0).');
        valid = false;
    }
    return valid;
}

// ============================================================
// COUPON VALIDATION
// ============================================================
function validateCoupon(form) {
    let valid = true;
    clearErrors(['couponCodeErr', 'discPctErr', 'maxUsesErr', 'validUntilErr']);

    if (!form.code.value.trim()) {
        showError('couponCodeErr', 'Coupon code is required.');
        valid = false;
    }
    const disc = parseFloat(form.discount_pct.value);
    if (isNaN(disc) || disc <= 0 || disc > 100) {
        showError('discPctErr', 'Discount must be between 1 and 100.');
        valid = false;
    }
    const uses = parseInt(form.max_uses.value);
    if (isNaN(uses) || uses < 1) {
        showError('maxUsesErr', 'Max uses must be at least 1.');
        valid = false;
    }
    if (!form.valid_until.value) {
        showError('validUntilErr', 'Please choose an expiry date.');
        valid = false;
    }
    return valid;
}

// ============================================================
// PASSWORD MATCH CHECK (profile page)
// ============================================================
function checkPassMatch() {
    const np = document.getElementById('newPass');
    const cp = document.getElementById('confirmPass');
    const err = document.getElementById('confirmPassErr');
    if (np && cp && err) {
        if (np.value !== cp.value) {
            err.textContent = 'Passwords do not match.';
            return false;
        }
        err.textContent = '';
    }
    return true;
}

// ============================================================
// AJAX — Refresh Low Stock Panel (XMLHttpRequest)
// ============================================================
function loadLowStock() {
    const panel = document.getElementById('lowStockPanel');
    if (!panel) return;

    panel.innerHTML = '<p style="color:#888">Loading...</p>';

    const xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status === 200) {
            let products = JSON.parse(xhr.responseText);
            if (products.length === 0) {
                panel.innerHTML = '<div class="alert alert-success">✅ All products have sufficient stock.</div>';
            } else {
                let html = '<div class="alert alert-warning">⚠️ <strong>' + products.length + '</strong> product(s) are low on stock (≤ 5 units).<ul style="margin-top:6px">';
                for (let i = 0; i < products.length; i++) {
                    html += '<li>' + escapeHtml(products[i].name) + ' — <strong>' + products[i].stock_qty + '</strong> left</li>';
                }
                html += '</ul></div>';
                panel.innerHTML = html;
            }
        } else {
            panel.innerHTML = '<div class="alert alert-danger">Failed to load stock data.</div>';
        }
    };
    xhr.onerror = function () {
        panel.innerHTML = '<div class="alert alert-danger">Network error. Please try again.</div>';
    };
    xhr.open('GET', '../../controllers/ProductLowStockAjaxController.php?threshold=5', true);
    xhr.send();
}

// ============================================================
// ANALYTICS — Bar Chart (Canvas)
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('volumeChart');
    if (!canvas || typeof volumeData === 'undefined' || volumeData.length === 0) return;

    const ctx    = canvas.getContext('2d');
    const labels = volumeData.map(d => d.day);
    const values = volumeData.map(d => parseInt(d.order_count));
    const maxVal = Math.max(...values, 1);
    const W      = canvas.offsetWidth || 800;
    const H      = 200;
    canvas.width  = W;
    canvas.height = H;

    const barW  = Math.max(8, (W - 60) / labels.length - 4);
    const chartH = H - 40;
    const startX = 50;

    // Y axis
    ctx.strokeStyle = '#ccc';
    ctx.beginPath();
    ctx.moveTo(startX, 10);
    ctx.lineTo(startX, chartH + 10);
    ctx.stroke();

    labels.forEach(function (label, i) {
        const barH = Math.max(2, Math.round((values[i] / maxVal) * chartH));
        const x    = startX + i * ((W - 60) / labels.length) + 2;
        const y    = chartH + 10 - barH;

        // Bar
        ctx.fillStyle = '#3498db';
        ctx.fillRect(x, y, barW, barH);

        // Value label
        ctx.fillStyle = '#333';
        ctx.font      = '11px Arial';
        ctx.textAlign = 'center';
        if (values[i] > 0) {
            ctx.fillText(values[i], x + barW / 2, y - 3);
        }

        // Date label (every 5th or if few)
        if (i % Math.ceil(labels.length / 10) === 0) {
            ctx.fillStyle = '#888';
            ctx.font      = '10px Arial';
            ctx.fillText(label.slice(5), x + barW / 2, H - 5); // show MM-DD
        }
    });
});

// ============================================================
// Helpers
// ============================================================
function showError(id, msg) {
    const el = document.getElementById(id);
    if (el) el.textContent = msg;
}

function clearErrors(ids) {
    ids.forEach(function (id) { showError(id, ''); });
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}