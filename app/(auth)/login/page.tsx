export default function LoginPage() {
  return (
    <form action="/api/auth/login" method="post" className="card mx-auto max-w-md space-y-4">
      <h1 className="text-2xl font-bold text-brand-100">Connexion</h1>
      <input required name="email" type="email" placeholder="Email" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
      <input required name="password" type="password" placeholder="Mot de passe" className="w-full rounded-lg border border-slate-700 bg-slate-950 p-2" />
      <button className="w-full rounded-lg bg-brand-500 p-2 font-semibold text-slate-900">Se connecter</button>
    </form>
  );
}
