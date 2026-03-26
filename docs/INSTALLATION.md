# Installation locale

## Prérequis
- PHP 8.1+
- MySQL 8+
- Apache/Nginx ou `php -S`
- phpMyAdmin (optionnel mais recommandé)

## Étapes
1. Copier la config exemple:
   - `cp config/config.example.php config/config.php`
2. Adapter la connexion MySQL dans `config/config.php`.
3. Importer `database/schema.sql`.
4. Démarrer l'application:
   - `php -S localhost:8000 -t public`
5. Tester:
   - Site public: `/`
   - Login client: `/login`
   - Login admin séparé: `/admin/login`

## Dépannage
- Erreur DB: vérifier host/port/user/password.
- 404 routes: vérifier `public/.htaccess` (Apache) ou document root `public/`.
