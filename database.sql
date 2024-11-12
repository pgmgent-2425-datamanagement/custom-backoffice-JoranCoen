CREATE TABLE IF NOT EXISTS users (
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
    role ENUM('admin', 'user', 'moderator') NOT NULL DEFAULT 'user',
    profile_picture VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS coins (
    coin_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    coin_name VARCHAR(255) NOT NULL,
    symbol VARCHAR(255) NOT NULL,
    market_cap DECIMAL(20,2) NOT NULL,
    price DECIMAL(20,2) NOT NULL,
    circulating_supply DECIMAL(20,2) NOT NULL,
    total_supply DECIMAL(20,2) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description TEXT DEFAULT NULL,
    PRIMARY KEY (coin_id)
);

CREATE TABLE IF NOT EXISTS wallets (
    wallet_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    coin_id INT UNSIGNED NOT NULL,
    balance DECIMAL(20,2) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    wallet_address VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    notes TEXT DEFAULT NULL,
    PRIMARY KEY (wallet_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (coin_id) REFERENCES coins(coin_id)
);

CREATE TABLE IF NOT EXISTS transactions (
    transaction_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    wallet_id INT UNSIGNED NOT NULL,
    coin_id INT UNSIGNED NOT NULL,
    amount DECIMAL(20,2) NOT NULL,
    transaction_type ENUM('buy', 'sell') NOT NULL DEFAULT 'buy',
    transaction_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending',
    fee DECIMAL(10,2) NOT NULL,
    reference_id VARCHAR(255) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    PRIMARY KEY (transaction_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (coin_id) REFERENCES coins(coin_id),
    FOREIGN KEY (wallet_id) REFERENCES wallets(wallet_id)
);

CREATE TABLE IF NOT EXISTS coin_prices (
    price_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    coin_id INT UNSIGNED NOT NULL,
    price DECIMAL(20,2) NOT NULL,
    date_recorded DATETIME NOT NULL,
    high DECIMAL(20,2) NOT NULL,
    low DECIMAL(20,2) NOT NULL,
    volume DECIMAL(20,2) NOT NULL,
    market_cap DECIMAL(20,2) NOT NULL,
    change_percentage DECIMAL(5,2) NOT NULL,
    notes TEXT DEFAULT NULL,
    PRIMARY KEY (price_id),
    FOREIGN KEY (coin_id) REFERENCES coins(coin_id)
);

CREATE TABLE IF NOT EXISTS user_roles (
    role_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    role_name VARCHAR(255) NOT NULL,
    permissions TEXT DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    description TEXT DEFAULT NULL,
    parent_role_id INT UNSIGNED DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    level INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (role_id),
    FOREIGN KEY (parent_role_id) REFERENCES user_roles(role_id)
);

CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'warning', 'alert') NOT NULL DEFAULT 'info',
    reference_id VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (notification_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS settings (
    setting_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    setting_key VARCHAR(255) NOT NULL,
    setting_value TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    description TEXT DEFAULT NULL,
    type ENUM('system', 'user') NOT NULL DEFAULT 'system',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    notes TEXT DEFAULT NULL,
    user_id INT UNSIGNED DEFAULT NULL,
    PRIMARY KEY (setting_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS audit_logs (
    log_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    action VARCHAR(255) NOT NULL,
    timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(255) DEFAULT NULL,
    user_agent VARCHAR(255) DEFAULT NULL,
    status ENUM('success', 'failure') NOT NULL DEFAULT 'success',
    notes TEXT DEFAULT NULL,
    reference_id VARCHAR(255) DEFAULT NULL,
    user_id INT UNSIGNED NOT NULL,
    details TEXT DEFAULT NULL,
    PRIMARY KEY (log_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO users (username, email, password_hash, status, role, profile_picture)
VALUES 
    ('john_doe', 'john@example.com', 'hashed_password_123', 'active', 'user', NULL),
    ('jane_doe', 'jane@example.com', 'hashed_password_456', 'active', 'admin', NULL),
    ('alice', 'alice@example.com', 'hashed_password_789', 'suspended', 'moderator', NULL),
    ('bob_smith', 'bob@example.com', 'hashed_password_234', 'active', 'user', NULL),
    ('carol', 'carol@example.com', 'hashed_password_567', 'inactive', 'user', NULL);

INSERT INTO coins (coin_name, symbol, market_cap, price, circulating_supply, total_supply, description)
VALUES 
    ('Bitcoin', 'BTC', 900000000000, 45000, 19000000, 21000000, 'The first decentralized digital currency.'),
    ('Ethereum', 'ETH', 450000000000, 3000, 115000000, 120000000, 'A decentralized platform for smart contracts.'),
    ('Litecoin', 'LTC', 10000000000, 180, 66000000, 84000000, 'A peer-to-peer cryptocurrency with low fees.');

INSERT INTO coin_prices (coin_id, price, date_recorded, high, low, volume, market_cap, change_percentage, notes)
VALUES
    (1, 45000, '2024-01-01', 46000, 44000, 5000000, 900000000000, -2.5, 'January record for Bitcoin'),
    (1, 46000, '2024-02-01', 47000, 45000, 5200000, 920000000000, 2.2, 'February record for Bitcoin'),
    (1, 47000, '2024-03-01', 47500, 46500, 5300000, 940000000000, 1.1, 'March record for Bitcoin'),
    (1, 48000, '2024-04-01', 48500, 47500, 5400000, 960000000000, 2.1, 'April record for Bitcoin'),
    (1, 49000, '2024-05-01', 49500, 48500, 5500000, 980000000000, 2.0, 'May record for Bitcoin'),
    (1, 48500, '2024-06-01', 49000, 48000, 5300000, 970000000000, -1.0, 'June record for Bitcoin'),
    (1, 49500, '2024-07-01', 50000, 49000, 5600000, 990000000000, 2.0, 'July record for Bitcoin'),
    (1, 50000, '2024-08-01', 50500, 49500, 5700000, 1000000000000, 1.0, 'August record for Bitcoin'),
    (1, 51000, '2024-09-01', 51500, 50500, 5800000, 1020000000000, 2.0, 'September record for Bitcoin'),
    (1, 52000, '2024-10-01', 52500, 51500, 5900000, 1040000000000, 2.0, 'October record for Bitcoin'),
    (1, 53000, '2024-11-01', 53500, 52500, 6000000, 1060000000000, 2.0, 'November record for Bitcoin'),
    (1, 54000, '2024-12-01', 54500, 53500, 6100000, 1080000000000, 2.0, 'December record for Bitcoin'),
    (2, 3000, '2024-01-01', 3100, 2950, 3000000, 450000000000, 1.5, 'January record for Ethereum'),
    (2, 3100, '2024-02-01', 3200, 3050, 3100000, 470000000000, 3.3, 'February record for Ethereum'),
    (2, 3200, '2024-03-01', 3300, 3150, 3200000, 490000000000, 3.2, 'March record for Ethereum'),
    (2, 3350, '2024-04-01', 3400, 3300, 3300000, 505000000000, 4.7, 'April record for Ethereum'),
    (2, 3250, '2024-05-01', 3300, 3200, 3400000, 490000000000, -3.0, 'May record for Ethereum'),
    (2, 3450, '2024-06-01', 3500, 3400, 3500000, 515000000000, 6.2, 'June record for Ethereum'),
    (2, 3550, '2024-07-01', 3600, 3500, 3600000, 530000000000, 2.9, 'July record for Ethereum'),
    (2, 3400, '2024-08-01', 3450, 3350, 3700000, 510000000000, -4.2, 'August record for Ethereum'),
    (2, 3650, '2024-09-01', 3700, 3600, 3800000, 550000000000, 7.4, 'September record for Ethereum'),
    (2, 3750, '2024-10-01', 3800, 3700, 3900000, 565000000000, 2.7, 'October record for Ethereum'),
    (2, 3850, '2024-11-01', 3900, 3800, 4000000, 580000000000, 2.7, 'November record for Ethereum'),
    (2, 3950, '2024-12-01', 4000, 3900, 4100000, 595000000000, 2.6, 'December record for Ethereum'),
    (3, 180, '2024-01-01', 185, 175, 2000000, 10000000000, -1.2, 'January record for Litecoin'),
    (3, 190, '2024-02-01', 195, 185, 2100000, 10500000000, 5.6, 'February record for Litecoin'),
    (3, 200, '2024-03-01', 205, 195, 2200000, 11000000000, 5.3, 'March record for Litecoin'),
    (3, 195, '2024-04-01', 200, 190, 2150000, 10750000000, -2.5, 'April record for Litecoin'),
    (3, 210, '2024-05-01', 215, 205, 2300000, 11200000000, 7.7, 'May record for Litecoin'),
    (3, 205, '2024-06-01', 210, 200, 2250000, 10900000000, -2.4, 'June record for Litecoin'),
    (3, 215, '2024-07-01', 220, 210, 2350000, 11500000000, 4.9, 'July record for Litecoin'),
    (3, 220, '2024-08-01', 225, 215, 2400000, 11750000000, 2.3, 'August record for Litecoin'),
    (3, 230, '2024-09-01', 235, 225, 2500000, 12200000000, 4.5, 'September record for Litecoin'),
    (3, 225, '2024-10-01', 230, 220, 2450000, 12000000000, -2.2, 'October record for Litecoin'),
    (3, 235, '2024-11-01', 240, 230, 2600000, 12500000000, 4.4, 'November record for Litecoin'),
    (3, 240, '2024-12-01', 245, 235, 2700000, 12750000000, 2.1, 'December record for Litecoin');

INSERT INTO wallets (user_id, coin_id, balance, wallet_address, status, notes)
VALUES 
    (1, 3, 5.0, 'wallet123458', 'active', 'Litecoin wallet'),
    (2, 1, 0.8, 'wallet123459', 'active', 'Bitcoin wallet'),
    (2, 2, 3.0, 'wallet123460', 'active', 'Ethereum wallet'),
    (3, 1, 0.0, 'wallet123461', 'inactive', 'Inactive Bitcoin wallet'),
    (3, 3, 10.0, 'wallet123462', 'active', 'Active Litecoin wallet'),
    (3, 2, 8.0, 'wallet123463', 'active', 'Ethereum wallet'),
    (2, 3, 20.0, 'wallet123464', 'active', 'Litecoin wallet'),
    (1, 2, 25.0, 'wallet123465', 'active', 'Main Ethereum wallet'),
    (1, 1, 10.0, 'wallet123466', 'active', 'Main Bitcoin wallet');

INSERT INTO transactions (user_id, wallet_id, coin_id, amount, transaction_type, transaction_date, status, fee, reference_id, notes)
VALUES 
    (1, 1, 1, 0.2, 'buy', NOW() - INTERVAL 40 DAY, 'completed', 1.0, 'REF123467', 'Purchased 0.2 BTC in wallet 1'),
    (1, 2, 1, 0.5, 'sell', NOW() - INTERVAL 50 DAY, 'completed', 1.1, 'REF123468', 'Sold 0.5 BTC from wallet 2'),
    (2, 3, 2, 5, 'buy', NOW() - INTERVAL 12 DAY, 'completed', 0.9, 'REF123469', 'Purchased 5 ETH in wallet 3'),
    (2, 2, 2, 2, 'sell', NOW() - INTERVAL 9 DAY, 'completed', 0.5, 'REF123470', 'Sold 2 ETH from wallet 2'),
    (3, 4, 3, 10, 'buy', NOW() - INTERVAL 15 DAY, 'completed', 1.3, 'REF123471', 'Purchased 10 LTC in wallet 4'),
    (3, 3, 3, 7, 'sell', NOW() - INTERVAL 20 DAY, 'completed', 0.6, 'REF123472', 'Sold 7 LTC from wallet 3'),
    (1, 3, 2, 5, 'buy', NOW() - INTERVAL 30 DAY, 'pending', 0.7, 'REF123473', 'Pending purchase of 5 ETH in wallet 3'),
    (1, 1, 1, 1, 'sell', NOW() - INTERVAL 35 DAY, 'failed', 0.8, 'REF123474', 'Failed attempt to sell 1 BTC from wallet 1'),
    (2, 4, 1, 0.3, 'buy', NOW() - INTERVAL 5 DAY, 'completed', 0.5, 'REF123475', 'Purchased 0.3 BTC in wallet 4'),
    (3, 2, 2, 10, 'sell', NOW() - INTERVAL 60 DAY, 'completed', 1.2, 'REF123476', 'Sold 10 ETH from wallet 2'),
    (2, 1, 3, 4, 'buy', NOW() - INTERVAL 22 DAY, 'completed', 0.9, 'REF123477', 'Purchased 4 LTC in wallet 1'),
    (2, 3, 3, 2, 'sell', NOW() - INTERVAL 18 DAY, 'completed', 0.6, 'REF123478', 'Sold 2 LTC from wallet 3'),
    (1, 2, 2, 7, 'buy', NOW() - INTERVAL 10 DAY, 'completed', 0.4, 'REF123479', 'Purchased 7 ETH in wallet 2'),
    (3, 1, 1, 0.4, 'buy', NOW() - INTERVAL 45 DAY, 'completed', 1.0, 'REF123480', 'Purchased 0.4 BTC in wallet 1'),
    (1, 4, 1, 1, 'sell', NOW() - INTERVAL 25 DAY, 'failed', 0.8, 'REF123481', 'Failed attempt to sell 1 BTC from wallet 4'),
    (2, 5, 3, 3, 'buy', NOW() - INTERVAL 40 DAY, 'completed', 0.7, 'REF123482', 'Purchased 3 LTC in wallet 2'),
    (2, 3, 1, 0.5, 'sell', NOW() - INTERVAL 35 DAY, 'completed', 0.9, 'REF123483', 'Sold 0.5 BTC from wallet 3'),
    (3, 5, 2, 8, 'buy', NOW() - INTERVAL 55 DAY, 'completed', 1.1, 'REF123484', 'Purchased 8 ETH in wallet 4'),
    (3, 5, 3, 6, 'sell', NOW() - INTERVAL 50 DAY, 'completed', 0.8, 'REF123485', 'Sold 6 LTC from wallet 1');

INSERT INTO user_roles (role_name, permissions, description, parent_role_id, notes, level)
VALUES  
    ('admin', 'all', 'Admin role', NULL, 'Has all permissions', 1),
    ('moderator', 'manage_users, manage_coins', 'Moderator role', 1, 'Can manage users and coins', 2),
    ('user', 'view_profile, view_wallets, view_transactions', 'User role', 2, 'Can view profile, wallets, and transactions', 3);

INSERT INTO notifications (user_id, message, type, reference_id)
VALUES
    (1, 'Your wallet 1 has been updated.', 'info', 'wallet123458'),
    (2, 'New transaction completed.', 'warning', 'REF123475'),
    (3, 'Your account has been suspended.', 'alert', NULL);
