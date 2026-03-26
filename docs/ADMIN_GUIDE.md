# Guide administrateur SecurGame

## Accès
- URL: `/admin`
- Compte démo: `admin@securgame.local` / `SecurGame123!`

## Pages
- Dashboard: métriques principales
- Clients: liste utilisateurs + rôles
- Produits: CRUD simple des jeux
- Offres: CRUD simple des offres (prix, RAM, CPU, stockage, slots, statut)
- Services / Commandes / Factures: suivi opérationnel
- Intégrations: configuration Pterodactyl/Stripe (test/production)

## Bonnes pratiques
- Changer immédiatement le mot de passe admin de démo.
- Renseigner les clés externes uniquement en production sécurisée.
- Restreindre l'accès au dossier `config` côté serveur.
