import { NextResponse } from "next/server";
import { pterodactylTestSchema } from "@/lib/validators";
import { getServerPanelClient } from "@/lib/integrations/pterodactyl";

export async function POST(req: Request) {
  const form = await req.formData();
  const parsed = pterodactylTestSchema.safeParse({
    baseUrl: form.get("baseUrl"),
    apiKey: form.get("apiKey")
  });

  if (!parsed.success) {
    return NextResponse.json({ ok: false, message: "Paramètres invalides" }, { status: 400 });
  }

  const client = await getServerPanelClient();
  const result = await client.testConnection(parsed.data);
  return NextResponse.json(result);
}
