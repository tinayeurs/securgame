# Installation locale rapide

## Prérequis
- PHP 8.1+
- MySQL 8+
- phpMyAdmin recommandé

## Étapes
1. Créer une base `securgame` (ou laisser le script SQL la créer).
2. Importer `database/schema.sql`.
3. Copier `config/config.example.php` en `config/config.php`.
4. Modifier l'hôte/utilisateur/mot de passe MySQL.
5. Démarrer:
   `php -S localhost:8000 -t public`

## Vérification
- `/` page d'accueil
- `/login` connexion
- `/admin` dashboard admin (avec compte démo)
- `/client` dashboard client
