# Guide administrateur SecurGame

## Connexion admin dédiée
- URL : `/admin/login`
- Compte démo : `admin@securgame.local`
- Mot de passe : `SecurGame123!`

## Modules admin
- Dashboard global (KPI)
- Clients
- Administrateurs
- Jeux
- Produits
- Offres
- Commandes
- Services
- Facturation (factures + paiements)
- Intégrations (Pterodactyl/Stripe)

## Logique métier
- Une commande payée déclenche la création d'un service.
- Le service passe en provisioning puis en actif (ou failed).
- Les logs techniques sont visibles dans `service_provisioning_logs`.

## Bonnes pratiques
- Changer les mots de passe démo immédiatement.
- Configurer les clés Stripe/Pterodactyl via l'admin.
- Restreindre l'accès au panel admin.
