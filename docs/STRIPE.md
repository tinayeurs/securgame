# Intégration Stripe

L'adaptateur est défini dans `lib/integrations/stripe.ts`.

- Le mode mock est activé en développement.
- Endpoint webhook: `/api/stripe/webhook`.
- Les paiements passent par des sessions Checkout.
