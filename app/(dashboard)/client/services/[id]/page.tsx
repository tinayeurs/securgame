import { getServerPanelClient } from "@/lib/integrations/pterodactyl";

export default async function ServiceDetailPage({ params }: { params: { id: string } }) {
  const panel = await getServerPanelClient();
  const status = await panel.getServerStatus(params.id);

  return (
    <section className="space-y-4">
      <h1 className="text-3xl font-bold text-brand-100">Service #{params.id}</h1>
      <div className="card">
        <p>Statut: {status.state}</p>
        <p>CPU: {status.cpu}%</p>
        <p>RAM: {status.memoryMb} MB</p>
      </div>
    </section>
  );
}
