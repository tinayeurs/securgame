import Link from "next/link";

export default function AdminDashboardPage() {
  return (
    <section className="space-y-4">
      <h1 className="text-3xl font-bold text-brand-100">Administration</h1>
      <div className="grid gap-4 md:grid-cols-3">
        <Link href="/admin/products" className="card">Produits et offres</Link>
        <Link href="/admin/invoices" className="card">Facturation</Link>
        <Link href="/admin/integrations" className="card">Intégrations</Link>
      </div>
    </section>
  );
}
