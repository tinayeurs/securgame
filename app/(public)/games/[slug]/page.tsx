import { notFound } from "next/navigation";

const gameMap: Record<string, { title: string; description: string }> = {
  minecraft: { title: "Minecraft", description: "Serveurs Paper/Forge/Fabric prêts à l'emploi." },
  fivem: { title: "FiveM", description: "Slots flexibles, txAdmin, backup automatique." },
  hytale: { title: "Hytale", description: "Préconfiguration anticipée pour lancement officiel." },
  csgo: { title: "CSGO", description: "Tickrate stable et plugins workshop." },
  rust: { title: "Rust", description: "Map wipes programmables et monitoring performant." },
  "garrys-mod": { title: "Garry's Mod", description: "Collections Steam et FastDL optimisé." }
};

export default function GamePage({ params }: { params: { slug: string } }) {
  const game = gameMap[params.slug];
  if (!game) notFound();

  return (
    <article className="card">
      <h1 className="text-3xl font-bold text-brand-100">{game.title}</h1>
      <p className="mt-4 text-slate-300">{game.description}</p>
    </article>
  );
}
