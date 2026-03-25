# Configuration administrateur

## États d'intégration
- `NOT_CONFIGURED`
- `TESTING`
- `CONNECTED`
- `ERROR`

## Pterodactyl
1. Aller dans `/admin/integrations`.
2. Renseigner URL et API key.
3. Cliquer sur **Tester la connexion**.
4. Sauvegarder en base (à implémenter selon workflow final).

## Stripe
1. Aller dans `/admin/integrations`.
2. Renseigner `sk_test` ou `sk_live`.
3. Tester.
4. Configurer le webhook `/api/stripe/webhook` dans le dashboard Stripe.
