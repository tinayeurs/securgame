CREATE DATABASE IF NOT EXISTS securgame CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE securgame;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  status ENUM('active','suspended','deleted') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role_name ENUM('owner','manager','support') NOT NULL DEFAULT 'manager',
  status ENUM('active','disabled') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  company_name VARCHAR(190) NULL,
  phone VARCHAR(40) NULL,
  billing_address TEXT NULL,
  vat_number VARCHAR(50) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  game_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  description TEXT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (game_id) REFERENCES games(id),
  INDEX idx_products_game_active (game_id, is_active)
);

CREATE TABLE offers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  description TEXT NULL,
  price_monthly DECIMAL(10,2) NOT NULL,
  setup_fee DECIMAL(10,2) NOT NULL DEFAULT 0,
  ram_mb INT NOT NULL,
  cpu_cores INT NOT NULL,
  storage_gb INT NOT NULL,
  slots INT NOT NULL DEFAULT 20,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  ptero_egg_id INT NULL,
  ptero_nest_id INT NULL,
  ptero_location_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id),
  INDEX idx_offers_product_active (product_id, is_active)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('draft','pending','paid','cancelled','refunded') NOT NULL DEFAULT 'pending',
  paid_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  INDEX idx_orders_user_status (user_id, status)
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  offer_id INT NOT NULL,
  item_name VARCHAR(190) NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (offer_id) REFERENCES offers(id)
);

CREATE TABLE invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  order_id INT NOT NULL,
  invoice_number VARCHAR(50) NOT NULL UNIQUE,
  amount DECIMAL(10,2) NOT NULL,
  status ENUM('draft','pending','paid','cancelled','refunded') NOT NULL DEFAULT 'pending',
  due_date DATE NULL,
  paid_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  INDEX idx_invoices_user_status (user_id, status)
);

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  invoice_id INT NOT NULL,
  transaction_reference VARCHAR(100) NOT NULL UNIQUE,
  amount DECIMAL(10,2) NOT NULL,
  method VARCHAR(50) NOT NULL,
  status ENUM('pending','paid','failed','cancelled','refunded') NOT NULL DEFAULT 'pending',
  raw_provider_payload JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (invoice_id) REFERENCES invoices(id),
  INDEX idx_payments_user_status (user_id, status)
);

CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  order_id INT NOT NULL,
  offer_id INT NOT NULL,
  external_server_id VARCHAR(120) NULL,
  status ENUM('pending','provisioning','active','suspended','expired','cancelled','failed') NOT NULL DEFAULT 'pending',
  provisioning_status ENUM('pending','provisioning','active','failed','cancelled') NOT NULL DEFAULT 'pending',
  expires_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (offer_id) REFERENCES offers(id),
  INDEX idx_services_user_status (user_id, status)
);

CREATE TABLE service_provisioning_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  service_id INT NOT NULL,
  status VARCHAR(60) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

CREATE TABLE integration_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  provider ENUM('pterodactyl','stripe') NOT NULL,
  config_key VARCHAR(100) NOT NULL,
  config_value TEXT NULL,
  mode ENUM('test','production') NOT NULL DEFAULT 'test',
  connection_status ENUM('not_configured','connected','error','in_progress') NOT NULL DEFAULT 'not_configured',
  is_configured TINYINT(1) NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_provider_key (provider, config_key)
);

CREATE TABLE site_settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(120) NOT NULL UNIQUE,
  setting_value TEXT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE admin_activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  admin_user_id INT NOT NULL,
  action VARCHAR(150) NOT NULL,
  entity_type VARCHAR(80) NULL,
  entity_id INT NULL,
  context TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (admin_user_id) REFERENCES admin_users(id)
);

INSERT INTO users (name, email, password_hash, status) VALUES
('Client Demo', 'client@securgame.local', '$2y$10$h8TIQMiOp7AywA8h6IHxuuPrsVxV6kKPIQubA8nVy4vzrRZA8m7LS', 'active');

INSERT INTO admin_users (name, email, password_hash, role_name, status) VALUES
('Admin SecurGame', 'admin@securgame.local', '$2y$10$h8TIQMiOp7AywA8h6IHxuuPrsVxV6kKPIQubA8nVy4vzrRZA8m7LS', 'owner', 'active');

-- Mot de passe comptes démo: SecurGame123!

INSERT INTO customers (user_id, company_name, phone, billing_address, vat_number)
VALUES (1, 'Demo Studio', '+33123456789', '12 Green Avenue', 'FR123456789');

INSERT INTO games (name, slug, description) VALUES
('Minecraft', 'minecraft', 'Serveurs survie, moddés et mini-jeux'),
('FiveM', 'fivem', 'Serveurs RP GTA V performants'),
('Hytale', 'hytale', 'Offres prêtes au lancement'),
('CSGO', 'csgo', 'Serveurs compétitifs basse latence'),
('Rust', 'rust', 'Hébergement orienté communauté/clans'),
('Garry''s Mod', 'garrys-mod', 'Serveurs sandbox et darkRP');

INSERT INTO products (game_id, name, slug, description, is_active, sort_order) VALUES
(1, 'Minecraft VPS Managed', 'minecraft-vps', 'Produit optimisé Paper/Forge', 1, 1),
(2, 'FiveM RP Hosting', 'fivem-rp', 'Produit RP haute performance', 1, 2),
(5, 'Rust Clan Hosting', 'rust-clan', 'Produit orienté wipe', 1, 3),
(6, 'GMod Premium Hosting', 'gmod-premium', 'Produit DarkRP prêt', 1, 4);

INSERT INTO offers (product_id, name, description, price_monthly, setup_fee, ram_mb, cpu_cores, storage_gb, slots, status, is_active, ptero_egg_id, ptero_nest_id, ptero_location_id) VALUES
(1, 'Starter', 'Petit serveur communautaire', 7.99, 0, 4096, 2, 25, 20, 'active', 1, 0, 0, 0),
(1, 'Performance', 'Pour serveurs moddés', 14.99, 0, 8192, 4, 60, 60, 'active', 1, 0, 0, 0),
(2, 'RP Pro', 'Offre FiveM stable', 18.99, 0, 8192, 4, 60, 64, 'active', 1, 0, 0, 0),
(3, 'Clan', 'Offre Rust clan', 15.99, 0, 6144, 4, 50, 80, 'active', 1, 0, 0, 0),
(4, 'DarkRP', 'Offre GMod premium', 12.99, 0, 4096, 3, 40, 64, 'active', 1, 0, 0, 0);

INSERT INTO integration_settings (provider, config_key, config_value, mode, connection_status, is_configured) VALUES
('pterodactyl', 'panel_name', '', 'test', 'not_configured', 0),
('pterodactyl', 'panel_url', '', 'test', 'not_configured', 0),
('pterodactyl', 'api_key', '', 'test', 'not_configured', 0),
('stripe', 'public_key', '', 'test', 'not_configured', 0),
('stripe', 'secret_key', '', 'test', 'not_configured', 0),
('stripe', 'webhook_secret', '', 'test', 'not_configured', 0);

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'SecurGame'),
('support_email', 'support@securgame.local');
