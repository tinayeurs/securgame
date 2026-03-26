# SecurGame - Plateforme SaaS d'hébergement de serveurs de jeux (PHP + MySQL)

SecurGame est une plateforme complète en PHP MVC + MySQL, pensée comme un outil métier d'hébergement (site public + tunnel de commande + facturation + espace client + panel admin séparé).

## Fonctionnalités clés
- **Site public commercial** : accueil, offres, pages jeux, comparatif, FAQ, contact.
- **Authentification séparée** :
  - Client : `/login`, `/register`
  - Admin : `/admin/login`
- **Tunnel de commande** : sélection d'offre → génération commande/facture → paiement → création service.
- **Provisioning automatisé (architecture prête)** : statut provisioning + logs métier + module dédié.
- **Espace client** : dashboard, services, détail service, commandes, factures, paiements, profil.
- **Espace admin** : dashboard, clients, admins, jeux, produits, offres, commandes, services, facturation, intégrations.
- **Intégrations préparées** : Pterodactyl + Stripe (config depuis l'admin, sans secret hardcodé).

## Stack
- PHP 8.1+
- MySQL 8+
- phpMyAdmin (recommandé)
- HTML/CSS/JS (sans dépendance Node.js obligatoire à l'exécution)

## Architecture
- `app/Core` : Router, Controller, View, Database(PDO), Session, CSRF, Auth
- `app/Controllers` : public, auth client, auth admin, checkout, client, admin
- `app/Models` : couches PDO préparées
- `app/Services` : logique métier checkout/paiement/provisioning
- `app/Views` : public, auth, checkout, client, admin
- `public` : front controller + assets
- `database/schema.sql` : schéma complet + seed demo
- `docs` : guides installation/phpMyAdmin/admin

## Installation rapide
1. Copier la config:
```bash
cp config/config.example.php config/config.php
```
2. Importer `database/schema.sql` dans MySQL.
3. Configurer les accès DB dans `config/config.php`.
4. Lancer:
```bash
php -S localhost:8000 -t public
```
5. Ouvrir `http://localhost:8000`.

## Comptes de démonstration
- **Client** : `client@securgame.local` / `SecurGame123!`
- **Admin** : `admin@securgame.local` / `SecurGame123!`

## Sécurité
- PDO + requêtes préparées
- hash mot de passe (`password_hash` / `password_verify`)
- CSRF sur formulaires sensibles
- séparation stricte sessions/guards client vs admin
- contrôle d'accès routes sensibles

## Remarque provisioning
Le provisioning est fonctionnellement orchestré (paiement -> service -> logs -> changement statut) avec un mode mock prêt à brancher sur l'API Pterodactyl.
