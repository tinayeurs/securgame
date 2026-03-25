const plans = [
  { game: "Minecraft", name: "Starter", ram: "4 Go", price: "7.99€" },
  { game: "FiveM", name: "Pro", ram: "8 Go", price: "14.99€" },
  { game: "Rust", name: "Elite", ram: "16 Go", price: "24.99€" }
];

export default function CataloguePage() {
  return (
    <section className="space-y-6">
      <h1 className="text-3xl font-bold text-brand-100">Catalogue des offres</h1>
      <div className="grid gap-4 md:grid-cols-3">
        {plans.map((plan) => (
          <article key={plan.name + plan.game} className="card">
            <p className="text-sm text-brand-100">{plan.game}</p>
            <h2 className="mt-1 text-2xl font-semibold">{plan.name}</h2>
            <p className="mt-2 text-slate-300">RAM: {plan.ram}</p>
            <p className="mt-4 text-2xl font-bold">{plan.price}/mois</p>
          </article>
        ))}
      </div>
    </section>
  );
}
