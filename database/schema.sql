CREATE DATABASE IF NOT EXISTS securgame CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE securgame;

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  company_name VARCHAR(190) NULL,
  phone VARCHAR(30) NULL,
  billing_address TEXT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE games (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  description TEXT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE offers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  game_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  price_monthly DECIMAL(10,2) NOT NULL,
  ram_mb INT NOT NULL,
  cpu_cores INT NOT NULL,
  storage_gb INT NOT NULL,
  slots INT DEFAULT 0,
  description TEXT NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (game_id) REFERENCES games(id),
  INDEX idx_offers_game_active (game_id, is_active)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('pending','paid','cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  INDEX idx_orders_user_status (user_id, status)
);

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  offer_id INT NOT NULL,
  order_id INT NULL,
  external_id VARCHAR(191) NULL,
  status ENUM('active','suspended','pending','expired') NOT NULL DEFAULT 'pending',
  expires_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (offer_id) REFERENCES offers(id),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  INDEX idx_services_user_status (user_id, status)
);

CREATE TABLE invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  order_id INT NULL,
  invoice_number VARCHAR(50) NOT NULL UNIQUE,
  amount DECIMAL(10,2) NOT NULL,
  status ENUM('paid','unpaid','cancelled','pending') DEFAULT 'unpaid',
  due_date DATE NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  INDEX idx_invoices_user_status (user_id, status)
);

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  invoice_id INT NULL,
  transaction_reference VARCHAR(100) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  method VARCHAR(50) NOT NULL,
  status ENUM('paid','failed','refunded','pending') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (invoice_id) REFERENCES invoices(id),
  INDEX idx_payments_user_status (user_id, status)
);

CREATE TABLE settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(100) NOT NULL UNIQUE,
  value TEXT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE external_integrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  provider ENUM('pterodactyl','stripe') NOT NULL,
  config_key VARCHAR(100) NOT NULL,
  config_value TEXT NULL,
  mode ENUM('test','production') DEFAULT 'test',
  is_configured TINYINT(1) DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_provider_key (provider, config_key)
);

CREATE TABLE admin_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  admin_user_id INT NOT NULL,
  action VARCHAR(190) NOT NULL,
  context TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (admin_user_id) REFERENCES users(id)
);

INSERT INTO roles (name) VALUES ('admin'), ('client');

INSERT INTO users (role_id, name, email, password_hash) VALUES
(1, 'Admin SecurGame', 'admin@securgame.local', '$2y$10$h8TIQMiOp7AywA8h6IHxuuPrsVxV6kKPIQubA8nVy4vzrRZA8m7LS'),
(2, 'Client Demo', 'client@securgame.local', '$2y$10$h8TIQMiOp7AywA8h6IHxuuPrsVxV6kKPIQubA8nVy4vzrRZA8m7LS');
-- Password for both demo accounts: SecurGame123!

INSERT INTO customers (user_id, company_name, phone, billing_address)
VALUES (2, 'Demo Studio', '+33123456789', '12 Green Avenue, Paris');

INSERT INTO games (name, slug, description, is_active) VALUES
('Minecraft', 'minecraft', 'Serveurs survie, moddés et mini-jeux.', 1),
('FiveM', 'fivem', 'Serveurs RP GTA V performants.', 1),
('Hytale', 'hytale', 'Préparation hébergement nouvelle génération.', 1),
('CSGO', 'csgo', 'Serveurs compétitifs à faible latence.', 1),
('Rust', 'rust', 'Serveurs custom avec monitoring.', 1),
('Garry''s Mod', 'garrys-mod', 'Serveurs sandbox et darkRP.', 1);

INSERT INTO offers (game_id, name, price_monthly, ram_mb, cpu_cores, storage_gb, slots, description, is_active) VALUES
(1, 'Minecraft Starter', 7.99, 4096, 2, 25, 20, 'Pour petits serveurs communautaires.', 1),
(2, 'FiveM RP Pro', 18.99, 8192, 4, 60, 64, 'Configuration stable pour RP.', 1),
(5, 'Rust Clan', 15.99, 6144, 4, 50, 80, 'Parfait pour serveurs de clan.', 1),
(6, 'GMod Premium', 12.99, 4096, 3, 40, 64, 'DarkRP prêt à personnaliser.', 1);

INSERT INTO orders (user_id, total_amount, status) VALUES (2, 18.99, 'paid');
INSERT INTO services (user_id, offer_id, order_id, external_id, status, expires_at)
VALUES (2, 2, 1, NULL, 'active', DATE_ADD(NOW(), INTERVAL 30 DAY));
INSERT INTO invoices (user_id, order_id, invoice_number, amount, status, due_date)
VALUES (2, 1, 'INV-2026-0001', 18.99, 'paid', DATE_ADD(CURDATE(), INTERVAL 14 DAY));
INSERT INTO payments (user_id, invoice_id, transaction_reference, amount, method, status)
VALUES (2, 1, 'PAY-DEMO-0001', 18.99, 'card', 'paid');

INSERT INTO external_integrations (provider, config_key, config_value, mode, is_configured) VALUES
('pterodactyl', 'url', '', 'test', 0),
('pterodactyl', 'api_key', '', 'test', 0),
('stripe', 'public_key', '', 'test', 0),
('stripe', 'secret_key', '', 'test', 0);
