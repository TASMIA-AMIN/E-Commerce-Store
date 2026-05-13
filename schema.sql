CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    role ENUM('customer','seller','delivery_manager','admin') NOT NULL,
    profile_pic VARCHAR(255),
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sellers (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    shop_name VARCHAR(100) NOT NULL,
    shop_description TEXT,
    shop_logo_path VARCHAR(255), address TEXT NOT NULL,
    is_approved BOOLEAN NOT NULL DEFAULT 0,
    commission_rate DECIMAL(5,2) DEFAULT 10 NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    parent_id INT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    FOREIGN KEY (parent_id) REFERENCES categories(id)
);

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    seller_id INT NOT NULL,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_qty INT NOT NULL DEFAULT 0,
    primary_image_path VARCHAR(255),
    is_available BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY(seller_id) REFERENCES sellers(id),
    FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE coupons (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    seller_id    INT NOT NULL,
    code         VARCHAR(50) NOT NULL,
    discount_pct DECIMAL(5,2) NOT NULL,
    max_uses     INT DEFAULT 0,
    uses_count   INT DEFAULT 0,
    valid_until  DATE NOT NULL,
    is_active    BOOLEAN NOT NULL DEFAULT 1,
    FOREIGN KEY (seller_id) REFERENCES sellers(id)
);

CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id               INT AUTO_INCREMENT PRIMARY KEY,
    customer_id      INT NOT NULL,
    shipping_address TEXT NOT NULL,
    payment_method   ENUM('cash_on_delivery','card') NOT NULL,
    subtotal         DECIMAL(10,2) NOT NULL,
    discount_amount  DECIMAL(10,2) DEFAULT 0,
    total_amount     DECIMAL(10,2) NOT NULL,
    status           ENUM('pending','confirmed','processing','shipped','delivered','cancelled','return_requested','returned') DEFAULT 'pending',
    coupon_id        INT DEFAULT NULL,
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id)
);

CREATE TABLE order_items (
     id         INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    order_id    INT NOT NULL,
    product_id  INT NOT NULL,
    seller_id   INT NOT NULL,
    quantity    INT NOT NULL,
    unit_price  DECIMAL(10,2) NOT NULL,
    item_status ENUM('pending','confirmed','shipped','delivered') DEFAULT 'pending',
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (seller_id) REFERENCES sellers(id)
);

CREATE TABLE reviews (
    id           INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    product_id   INT NOT NULL,
    order_id     INT NOT NULL,
    customer_id  INT NOT NULL,
    rating       TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review_text  TEXT,
    seller_reply TEXT,
    created_at   DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (customer_id) REFERENCES users(id)
);

CREATE TABLE return_requests (
    id            INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    order_id      INT NOT NULL,
    order_item_id INT NOT NULL,
    customer_id   INT NOT NULL,
    reason        TEXT,
    status        ENUM('pending','approved','rejected','completed') DEFAULT 'pending',
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (order_item_id) REFERENCES order_items(id),
    FOREIGN KEY (customer_id) REFERENCES users(id)
);
 