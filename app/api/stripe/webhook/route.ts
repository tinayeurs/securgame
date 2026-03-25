import { NextResponse } from "next/server";

export async function POST(req: Request) {
  const body = await req.text();
  console.log("stripe_webhook_received", { size: body.length });
  return NextResponse.json({ received: true });
}
