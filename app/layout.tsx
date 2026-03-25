import "./globals.css";
import Link from "next/link";
import { ReactNode } from "react";

export const metadata = {
  title: "SecurGame",
  description: "Plateforme SaaS de gestion de serveurs de jeux"
};

const nav = [
  { href: "/", label: "Accueil" },
  { href: "/catalogue", label: "Catalogue" },
  { href: "/faq", label: "FAQ" },
  { href: "/contact", label: "Contact" },
  { href: "/login", label: "Connexion" }
];

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    <html lang="fr">
      <body>
        <header className="sticky top-0 z-20 border-b border-slate-800 bg-slate-950/90 backdrop-blur">
          <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
            <Link href="/" className="text-xl font-semibold text-brand-100">
              SecurGame
            </Link>
            <nav className="flex gap-4 text-sm text-slate-300">
              {nav.map((item) => (
                <Link key={item.href} href={item.href} className="hover:text-brand-100">
                  {item.label}
                </Link>
              ))}
            </nav>
          </div>
        </header>
        <main className="mx-auto min-h-screen max-w-7xl px-4 py-8">{children}</main>
      </body>
    </html>
  );
}
