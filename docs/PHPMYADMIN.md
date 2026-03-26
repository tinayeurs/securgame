# Utilisation phpMyAdmin avec SecurGame

1. Ouvrir phpMyAdmin (ex: `http://localhost/phpmyadmin`).
2. Créer la base `securgame` en `utf8mb4_unicode_ci`.
3. Onglet **Importer** > sélectionner `database/schema.sql` > Exécuter.
4. Vérifier les tables: users, roles, customers, games, offers, services, orders, invoices, payments, settings, external_integrations, admin_logs.
5. Pour modifier des paramètres d'intégration:
   - soit via l'admin web `/admin/integrations`
   - soit via table `external_integrations`.
