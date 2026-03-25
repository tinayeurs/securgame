export default function RegisterPage() {
  return (
    <form action="/api/auth/register" method="post" className="card mx-auto max-w-md space-y-4">
      <h1 className="text-2xl font-bold text-brand-100">Inscription</h1>
      <input required name="name" placeholder="Nom" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
      <input required name="email" type="email" placeholder="Email" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
      <input required name="password" type="password" placeholder="Mot de passe" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
      <button className="w-full rounded-lg bg-brand-500 p-2 font-semibold text-slate-900">Créer mon compte</button>
    </form>
  );
}
