import Stripe from "stripe";

export interface BillingClient {
  testConnection(input: { secretKey: string }): Promise<{ ok: boolean; message: string }>;
  createCheckoutSession(input: { invoiceId: string; amountCents: number }): Promise<{ url: string }>;
}

class MockBillingClient implements BillingClient {
  async testConnection() {
    return { ok: true, message: "Mode mock: test Stripe simulé." };
  }

  async createCheckoutSession({ invoiceId }: { invoiceId: string; amountCents: number }) {
    return { url: `/client/invoices?paid=${invoiceId}` };
  }
}

class StripeBillingClient implements BillingClient {
  private stripe: Stripe;
  constructor(secretKey: string) {
    this.stripe = new Stripe(secretKey);
  }

  async testConnection() {
    await this.stripe.balance.retrieve();
    return { ok: true, message: "Connexion Stripe valide." };
  }

  async createCheckoutSession({ invoiceId, amountCents }: { invoiceId: string; amountCents: number }) {
    const session = await this.stripe.checkout.sessions.create({
      mode: "payment",
      line_items: [
        {
          quantity: 1,
          price_data: {
            currency: "eur",
            unit_amount: amountCents,
            product_data: { name: `Facture ${invoiceId}` }
          }
        }
      ],
      success_url: `${process.env.APP_URL}/client/invoices?success=${invoiceId}`,
      cancel_url: `${process.env.APP_URL}/client/invoices?cancel=${invoiceId}`
    });

    return { url: session.url ?? "/client/invoices" };
  }
}

export function getBillingClient(secretKey?: string): BillingClient {
  if (!secretKey || process.env.NODE_ENV === "development") {
    return new MockBillingClient();
  }

  return new StripeBillingClient(secretKey);
}
