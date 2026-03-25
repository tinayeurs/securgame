# SecurGame

Plateforme SaaS complète de vente et gestion de serveurs de jeux (Minecraft, FiveM, Hytale, CSGO, Rust, Garry's Mod), avec portail client/admin, facturation et intégrations Pterodactyl/Stripe.

## Stack
- Next.js 14 + React 18 + TypeScript strict
- Tailwind CSS (thème vert clair premium)
- Prisma ORM + PostgreSQL
- Auth session JWT httpOnly
- Adaptateurs d'intégration Pterodactyl/Stripe avec mode mock

## Modules livrés
- **Site public**: homepage, catalogue, pages jeu, FAQ, contact.
- **Auth**: inscription, connexion, session sécurisée.
- **Espace client**: dashboard, détail service, factures, profil.
- **Espace admin**: dashboard, gestion produits/factures, test intégrations.
- **Facturation**: endpoint paiement facture + webhook Stripe.
- **Sécurité**: validation Zod, middleware de protection des routes, aucune clé hardcodée en frontend.

## Lancement local
```bash
cp .env.example .env
./scripts/dev.sh
```

Ou manuellement:
```bash
docker compose up -d postgres
npm install
npm run prisma:generate
npm run prisma:migrate -- --name init
npm run prisma:seed
npm run dev
```

## Comptes de dev
- Admin: `admin@securgame.local`
- Mot de passe seed: `Admin1234!`

## Architecture
- `app/` routes Next.js (public + auth + client + admin + API)
- `lib/` logique métier (auth, validation, permissions, adapters)
- `prisma/` schéma DB et seed
- `docs/` guides intégration et administration

## Notes importantes
- Les identifiants externes sont configurables plus tard dans l'admin.
- En mode dev, les intégrations tombent en mock propre pour éviter tout blocage.
