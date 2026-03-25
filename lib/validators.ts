import { z } from "zod";

export const registerSchema = z.object({
  name: z.string().min(2).max(80),
  email: z.string().email(),
  password: z.string().min(8).max(120)
});

export const loginSchema = z.object({
  email: z.string().email(),
  password: z.string().min(8).max(120)
});

export const pterodactylTestSchema = z.object({
  baseUrl: z.string().url(),
  apiKey: z.string().min(10)
});

export const stripeTestSchema = z.object({
  secretKey: z.string().startsWith("sk_")
});
