import { PrismaClient, Role } from "@prisma/client";
import bcrypt from "bcryptjs";

const prisma = new PrismaClient();

async function main() {
  const adminPassword = await bcrypt.hash("Admin1234!", 12);
  const admin = await prisma.user.upsert({
    where: { email: "admin@securgame.local" },
    update: {},
    create: {
      email: "admin@securgame.local",
      name: "Admin SecurGame",
      passwordHash: adminPassword,
      role: Role.ADMIN
    }
  });

  const customer = await prisma.customer.upsert({
    where: { userId: admin.id },
    update: {},
    create: { userId: admin.id, company: "SecurGame" }
  });

  const minecraft = await prisma.product.upsert({
    where: { id: "minecraft-default" },
    update: {},
    create: {
      id: "minecraft-default",
      gameSlug: "minecraft",
      name: "Minecraft",
      description: "Serveur optimisé Paper/Fabric"
    }
  });

  await prisma.plan.upsert({
    where: { id: "minecraft-starter" },
    update: {},
    create: {
      id: "minecraft-starter",
      productId: minecraft.id,
      name: "Starter",
      priceCents: 799,
      ramMb: 4096,
      cpuPercent: 100,
      diskMb: 20480
    }
  });

  await prisma.auditLog.create({
    data: {
      actorId: admin.id,
      action: "seed.bootstrap",
      metadata: { customerId: customer.id }
    }
  });
}

main().finally(async () => {
  await prisma.$disconnect();
});
