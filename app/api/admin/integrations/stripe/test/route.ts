import { NextResponse } from "next/server";
import { getBillingClient } from "@/lib/integrations/stripe";
import { stripeTestSchema } from "@/lib/validators";

export async function POST(req: Request) {
  const form = await req.formData();
  const parsed = stripeTestSchema.safeParse({
    secretKey: form.get("secretKey")
  });

  if (!parsed.success) {
    return NextResponse.json({ ok: false, message: "Clé invalide" }, { status: 400 });
  }

  const client = getBillingClient(parsed.data.secretKey);
  const result = await client.testConnection({ secretKey: parsed.data.secretKey });
  return NextResponse.json(result);
}
