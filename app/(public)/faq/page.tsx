const items = [
  ["Puis-je gérer mon serveur sans Pterodactyl ?", "Oui, toutes les actions clés sont disponibles depuis SecurGame."],
  ["Stripe est-il obligatoire ?", "Oui pour les paiements en ligne, mais le mode mock reste disponible en dev."],
  ["Puis-je connecter plusieurs panels ?", "Oui, l'admin peut enregistrer plusieurs panels Pterodactyl."]
];

export default function FAQPage() {
  return (
    <section className="space-y-4">
      <h1 className="text-3xl font-bold text-brand-100">FAQ</h1>
      {items.map(([q, a]) => (
        <div key={q} className="card">
          <h2 className="font-semibold">{q}</h2>
          <p className="mt-2 text-slate-300">{a}</p>
        </div>
      ))}
    </section>
  );
}
