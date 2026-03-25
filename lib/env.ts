import { z } from "zod";

const schema = z.object({
  NODE_ENV: z.enum(["development", "test", "production"]).default("development"),
  DATABASE_URL: z.string().default("postgresql://postgres:postgres@localhost:5432/securgame"),
  JWT_SECRET: z.string().default("dev-only-change-me"),
  APP_URL: z.string().default("http://localhost:3000")
});

export const env = schema.parse(process.env);
