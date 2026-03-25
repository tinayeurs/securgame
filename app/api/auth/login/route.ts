import { NextResponse } from "next/server";
import { db } from "@/lib/db";
import { createSession, verifyPassword } from "@/lib/auth";
import { loginSchema } from "@/lib/validators";

export async function POST(req: Request) {
  const form = await req.formData();
  const parsed = loginSchema.safeParse({
    email: form.get("email"),
    password: form.get("password")
  });

  if (!parsed.success) return NextResponse.json({ error: "Données invalides" }, { status: 400 });

  const user = await db.user.findUnique({ where: { email: parsed.data.email } });
  if (!user) return NextResponse.json({ error: "Compte introuvable" }, { status: 404 });

  const ok = await verifyPassword(parsed.data.password, user.passwordHash);
  if (!ok) return NextResponse.json({ error: "Identifiants invalides" }, { status: 401 });

  await createSession(user.id, user.role);

  return NextResponse.redirect(new URL(user.role === "ADMIN" ? "/admin" : "/client", req.url));
}
