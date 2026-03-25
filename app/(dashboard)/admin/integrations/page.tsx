export default function AdminIntegrationsPage() {
  return (
    <section className="space-y-4">
      <h1 className="text-3xl font-bold text-brand-100">Intégrations externes</h1>
      <form action="/api/admin/integrations/pterodactyl/test" method="post" className="card space-y-2">
        <h2 className="text-xl font-semibold">Tester Pterodactyl</h2>
        <input name="baseUrl" placeholder="https://panel.example.com" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
        <input name="apiKey" placeholder="ptla_xxx" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
        <button className="rounded-lg bg-brand-500 px-4 py-2 font-semibold text-slate-900">Tester la connexion</button>
      </form>
      <form action="/api/admin/integrations/stripe/test" method="post" className="card space-y-2">
        <h2 className="text-xl font-semibold">Tester Stripe</h2>
        <input name="secretKey" placeholder="sk_test_xxx" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
        <button className="rounded-lg bg-brand-500 px-4 py-2 font-semibold text-slate-900">Tester la connexion</button>
      </form>
    </section>
  );
}
