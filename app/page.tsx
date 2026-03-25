import Link from "next/link";

const games = ["Minecraft", "FiveM", "Hytale", "CSGO", "Rust", "Garry's Mod"];

export default function HomePage() {
  return (
    <section className="space-y-8">
      <div className="card bg-gradient-to-br from-brand-900/70 via-slate-900 to-brand-700/40">
        <p className="text-sm uppercase tracking-[0.25em] text-brand-100">SaaS Gaming Hosting</p>
        <h1 className="mt-3 text-4xl font-bold">Déployez et gérez vos serveurs de jeux sans quitter SecurGame.</h1>
        <p className="mt-4 max-w-3xl text-slate-300">
          Vente, facturation, supervision et actions serveur Pterodactyl depuis un espace client moderne.
        </p>
        <div className="mt-6 flex flex-wrap gap-3">
          <Link href="/catalogue" className="rounded-xl bg-brand-500 px-4 py-2 font-semibold text-slate-900">
            Voir les offres
          </Link>
          <Link href="/register" className="rounded-xl border border-brand-100 px-4 py-2 text-brand-100">
            Créer un compte
          </Link>
        </div>
      </div>
      <div className="grid gap-4 md:grid-cols-3">
        {games.map((game) => (
          <Link key={game} href={`/games/${encodeURIComponent(game.toLowerCase().replace(/\s+/g, "-"))}`} className="card hover:border-brand-500">
            <h2 className="text-xl font-semibold text-brand-100">{game}</h2>
            <p className="mt-2 text-sm text-slate-400">Offres optimisées, anti-DDoS, monitoring temps réel.</p>
          </Link>
        ))}
      </div>
    </section>
  );
}
