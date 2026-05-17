function validateLogin(form) {
    var valid = true;
    clearErrors(['loginEmailErr', 'loginPassErr']);

    if (!form.email.value.trim()) {
        showError('loginEmailErr', 'Email is required.');
        valid = false;
    } else if (!isValidEmail(form.email.value.trim())) {
        showError('loginEmailErr', 'Enter a valid email address.');
        valid = false;
    }
    if (!form.password.value) {
        showError('loginPassErr', 'Password is required.');
        valid = false;
    }
    return valid;
}

function validateRegister(form) {
    var valid = true;
    clearErrors(['regNameErr', 'regEmailErr', 'regPassErr', 'regConfirmErr', 'regShopErr', 'regAddrErr']);

    if (!form.name.value.trim()) {
        showError('regNameErr', 'Full name is required.');
        valid = false;
    }
    if (!form.email.value.trim() || !isValidEmail(form.email.value.trim())) {
        showError('regEmailErr', 'A valid email is required.');
        valid = false;
    }
    if (form.password.value.length < 6) {
        showError('regPassErr', 'Password must be at least 6 characters.');
        valid = false;
    }
    if (form.password.value !== form.confirm_password.value) {
        showError('regConfirmErr', 'Passwords do not match.');
        valid = false;
    }
    if (!form.shop_name.value.trim()) {
        showError('regShopErr', 'Shop name is required.');
        valid = false;
    }
    if (!form.address.value.trim()) {
        showError('regAddrErr', 'Address is required.');
        valid = false;
    }
    return valid;
}

function validateProduct(form) {
    var valid = true;
    clearErrors(['pNameErr', 'pCatErr', 'pPriceErr', 'pStockErr']);

    if (!form.name.value.trim()) {
        showError('pNameErr', 'Product name is required.');
        valid = false;
    }
    if (!form.category_id.value) {
        showError('pCatErr', 'Please select a category.');
        valid = false;
    }
    var price = parseFloat(form.price.value);
    if (isNaN(price) || price < 0) {
        showError('pPriceErr', 'Enter a valid price (≥ 0).');
        valid = false;
    }
    var stock = parseInt(form.stock_qty.value);
    if (isNaN(stock) || stock < 0) {
        showError('pStockErr', 'Enter a valid stock quantity (≥ 0).');
        valid = false;
    }
    return valid;
}

function validateCoupon(form) {
    var valid = true;
    clearErrors(['couponCodeErr', 'discPctErr', 'maxUsesErr', 'validUntilErr']);

    if (!form.code.value.trim()) {
        showError('couponCodeErr', 'Coupon code is required.');
        valid = false;
    }
    var disc = parseFloat(form.discount_pct.value);
    if (isNaN(disc) || disc <= 0 || disc > 100) {
        showError('discPctErr', 'Discount must be between 1 and 100.');
        valid = false;
    }
    var uses = parseInt(form.max_uses.value);
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

function validateReply(form) {
    var errEl = form.querySelector('.reply-err');
    if (!form.reply.value.trim()) {
        if (errEl) errEl.textContent = 'Reply cannot be empty.';
        return false;
    }
    if (errEl) errEl.textContent = '';
    return true;
}

function checkPassMatch() {
    var np  = document.getElementById('newPass');
    var cp  = document.getElementById('confirmPass');
    var err = document.getElementById('confirmPassErr');
    if (np && cp && err) {
        if (np.value !== cp.value) {
            err.textContent = 'Passwords do not match.';
            return false;
        }
        err.textContent = '';
    }
    return true;
}

function tableSearch(input, tableId) {
    var filter = input.value.toLowerCase();
    var table  = document.getElementById(tableId);
    if (!table) return;
    var rows = table.getElementsByTagName('tr');
    for (var i = 1; i < rows.length; i++) {
        var text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.indexOf(filter) > -1 ? '' : 'none';
    }
}

function confirmDelete(msg) {
    return confirm(msg || 'Are you sure you want to delete this?');
}

function loadLowStock() {
    var panel = document.getElementById('lowStockPanel');
    if (!panel) return;
    panel.innerHTML = '<p style="color:#888;padding:8px 0">Loading…</p>';

    var xhr = new XMLHttpRequest();
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                var products = JSON.parse(xhr.responseText);
                if (products.length === 0) {
                    panel.innerHTML = '<div class="alert alert-success">✅ All products have sufficient stock.</div>';
                } else {
                    var html = '<div class="alert alert-warning">⚠️ <strong>' + products.length +
                               '</strong> product(s) are low on stock (≤ 5 units).<ul style="margin-top:6px">';
                    for (var i = 0; i < products.length; i++) {
                        html += '<li>' + escapeHtml(products[i].name) +
                                ' — <strong>' + parseInt(products[i].stock_qty) + '</strong> left</li>';
                    }
                    html += '</ul></div>';
                    panel.innerHTML = html;
                }
            } catch (e) {
                panel.innerHTML = '<div class="alert alert-danger">Invalid response from server.</div>';
            }
        } else {
            panel.innerHTML = '<div class="alert alert-danger">Failed to load stock data.</div>';
        }
    };
    xhr.onerror = function () {
        panel.innerHTML = '<div class="alert alert-danger">Network error. Please try again.</div>';
    };
    xhr.open('GET', 'ProductController.php?action=low_stock_ajax', true);
    xhr.send();
}

document.addEventListener('DOMContentLoaded', function () {

    // Primary product image preview
    var primaryInput   = document.getElementById('primaryImageInput');
    var primaryPreview = document.getElementById('primaryImagePreview');
    if (primaryInput && primaryPreview) {
        primaryInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    primaryPreview.src   = e.target.result;
                    primaryPreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Shop logo preview (register / profile pages)
    var logoInput   = document.getElementById('shopLogoInput');
    var logoPreview = document.getElementById('shopLogoPreview');
    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    logoPreview.src   = e.target.result;
                    logoPreview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    var canvas = document.getElementById('volumeChart');
    if (canvas && typeof volumeData !== 'undefined' && volumeData.length > 0) {
        drawBarChart(canvas, volumeData);
    }
});

function drawBarChart(canvas, data) {
    var ctx    = canvas.getContext('2d');
    var labels = data.map(function (d) { return d.day; });
    var values = data.map(function (d) { return parseInt(d.order_count); });
    var maxVal = Math.max.apply(null, values.concat([1]));

    var W      = canvas.parentElement.offsetWidth || 800;
    var H      = 220;
    canvas.width  = W;
    canvas.height = H;

    var chartH = H - 40;
    var startX = 40;
    var chartW = W - startX - 10;
    var barW   = Math.max(6, chartW / labels.length - 4);

    // Y gridlines
    ctx.strokeStyle = '#eee';
    ctx.lineWidth   = 1;
    for (var g = 1; g <= 4; g++) {
        var gy = chartH + 10 - Math.round((g / 4) * chartH);
        ctx.beginPath();
        ctx.moveTo(startX, gy);
        ctx.lineTo(W - 10, gy);
        ctx.stroke();
        ctx.fillStyle = '#bbb';
        ctx.font      = '10px Arial';
        ctx.textAlign = 'right';
        ctx.fillText(Math.round((g / 4) * maxVal), startX - 3, gy + 4);
    }

    // Y axis line
    ctx.strokeStyle = '#ccc';
    ctx.beginPath();
    ctx.moveTo(startX, 10);
    ctx.lineTo(startX, chartH + 10);
    ctx.stroke();

    // Bars
    var step = labels.length <= 20 ? 1 : Math.ceil(labels.length / 15);
    labels.forEach(function (label, i) {
        var barH = values[i] > 0 ? Math.max(3, Math.round((values[i] / maxVal) * chartH)) : 0;
        var x    = startX + i * (chartW / labels.length) + 2;
        var y    = chartH + 10 - barH;

        ctx.fillStyle = '#3498db';
        ctx.fillRect(x, y, barW, barH);

        if (values[i] > 0) {
            ctx.fillStyle = '#333';
            ctx.font      = '10px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(values[i], x + barW / 2, y - 3);
        }

        if (i % step === 0) {
            ctx.fillStyle = '#888';
            ctx.font      = '9px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(label.slice(5), x + barW / 2, H - 5);
        }
    });
}

function showError(id, msg) {
    var el = document.getElementById(id);
    if (el) el.textContent = msg;
}

function clearErrors(ids) {
    for (var i = 0; i < ids.length; i++) { showError(ids[i], ''); }
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g,  '&lt;')
        .replace(/>/g,  '&gt;')
        .replace(/"/g,  '&quot;');
}
