const invoices = [
  { id: "INV-001", amount: "14.99€", status: "open" },
  { id: "INV-002", amount: "24.99€", status: "paid" }
];

export default function ClientInvoicesPage() {
  return (
    <section className="space-y-4">
      <h1 className="text-3xl font-bold text-brand-100">Mes factures</h1>
      {invoices.map((invoice) => (
        <div key={invoice.id} className="card flex items-center justify-between">
          <div>
            <p className="font-semibold">{invoice.id}</p>
            <p className="text-slate-400">{invoice.status}</p>
          </div>
          <p>{invoice.amount}</p>
        </div>
      ))}
    </section>
  );
}
