# SecurGame (PHP + MySQL)

SecurGame est un site complet (front public, espace client, espace admin) recodé en **PHP + MySQL** avec une architecture MVC légère, sans dépendance Node.js obligatoire à l'exécution.

## Stack
- PHP 8.1+
- MySQL 8+
- phpMyAdmin (administration BDD)
- HTML/CSS/JS (responsive, thème clair vert)

## Arborescence
- `app/Core` : routeur, sécurité session/CSRF, vues
- `app/Controllers` : logique HTTP
- `app/Models` : accès données PDO (requêtes préparées)
- `app/Views` : pages publiques + client + admin
- `public` : point d'entrée (`index.php`)
- `config` : configuration app/db
- `database/schema.sql` : installation + données de démonstration
- `docs` : documentation d'installation et d'administration

## Installation locale
1. Copier la config exemple:
   ```bash
   cp config/config.example.php config/config.php
   ```
2. Importer `database/schema.sql` dans MySQL (via phpMyAdmin ou CLI).
3. Ajuster les accès DB dans `config/config.php`.
4. Lancer le serveur:
   ```bash
   php -S localhost:8000 -t public
   ```
5. Ouvrir `http://localhost:8000`.

## Comptes de démonstration
- Admin: `admin@securgame.local`
- Client: `client@securgame.local`
- Mot de passe: `SecurGame123!`

## Sécurité implémentée
- PDO + requêtes préparées
- sessions sécurisées (HttpOnly, SameSite)
- hash de mot de passe `password_hash`
- vérification rôles admin/client
- CSRF sur formulaires sensibles
- validation côté serveur

## Intégrations préparées
- Écran admin: `/admin/integrations`
- Paramètres prêts pour Pterodactyl et Stripe (mode test/production)
- Logique en placeholder tant que clés non configurées

## Compatibilité hébergement
Compatible avec XAMPP / WAMP / Laragon / MAMP et hébergement PHP mutualisé classique.
