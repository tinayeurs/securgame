# Intégration Pterodactyl

L'adaptateur est défini dans `lib/integrations/pterodactyl.ts`.

- En développement, un client mock est utilisé.
- Les actions sensibles doivent rester côté backend via API routes.
- Les clés API ne doivent jamais être exposées au frontend.
