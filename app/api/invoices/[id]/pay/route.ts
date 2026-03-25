import { NextResponse } from "next/server";
import { getBillingClient } from "@/lib/integrations/stripe";

export async function POST(req: Request, { params }: { params: { id: string } }) {
  const client = getBillingClient();
  const session = await client.createCheckoutSession({
    invoiceId: params.id,
    amountCents: 1499
  });

  return NextResponse.redirect(new URL(session.url, req.url));
}
