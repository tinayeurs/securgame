import Link from "next/link";

export default function ClientDashboardPage() {
  return (
    <section className="space-y-4">
      <h1 className="text-3xl font-bold text-brand-100">Espace client</h1>
      <div className="grid gap-4 md:grid-cols-3">
        <Link href="/client/services/1" className="card">Mes services</Link>
        <Link href="/client/invoices" className="card">Mes factures</Link>
        <Link href="/client/profile" className="card">Mon profil</Link>
      </div>
    </section>
  );
}
