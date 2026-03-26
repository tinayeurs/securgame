<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Game;
use App\Models\Offer;
use App\Models\Product;

final class PublicController extends Controller
{
    public function home(): void
    {
        $pdo = Database::connection($this->config);
        $games = (new Game($pdo))->allActive();
        $offers = array_slice((new Offer($pdo))->allCatalogue(), 0, 6);
        $products = (new Product($pdo))->allActive();
        $this->render('public/home', compact('games', 'offers', 'products'));
    }

    public function offers(): void
    {
        $offers = (new Offer(Database::connection($this->config)))->allCatalogue();
        $this->render('public/offers', compact('offers'));
    }

    public function pricing(): void
    {
        $offers = (new Offer(Database::connection($this->config)))->allCatalogue();
        $this->render('public/pricing', compact('offers'));
    }

    public function game(): void
    {
        $slug = (string) ($_GET['slug'] ?? '');
        $pdo = Database::connection($this->config);
        $game = (new Game($pdo))->findBySlug($slug);
        $all = (new Offer($pdo))->allCatalogue();
        $offers = array_values(array_filter($all, static fn (array $o): bool => $o['game_slug'] === $slug));
        $this->render('public/game', compact('game', 'offers'));
    }

    public function faq(): void
    {
        $this->render('public/faq');
    }

    public function contact(): void
    {
        $this->render('public/contact');
    }
}
