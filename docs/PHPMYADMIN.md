# Guide MySQL / phpMyAdmin

1. Ouvrir phpMyAdmin (souvent `http://localhost/phpmyadmin`).
2. Créer/importer la base avec `database/schema.sql`.
3. Contrôler les tables principales:
   - `users`, `admin_users`, `customers`
   - `games`, `products`, `offers`
   - `orders`, `order_items`, `invoices`, `payments`
   - `services`, `service_provisioning_logs`
   - `integration_settings`, `site_settings`, `admin_activity_logs`
4. Éditer les intégrations via l'admin (`/admin/integrations`) ou directement dans `integration_settings`.
5. Ne jamais stocker de secrets en dur dans le code.
