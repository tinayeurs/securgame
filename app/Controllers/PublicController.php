<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Game;
use App\Models\Offer;

final class PublicController extends Controller
{
    public function home(): void
    {
        $pdo = Database::connection($this->config);
        $offers = (new Offer($pdo))->publicCatalogue();
        $games = (new Game($pdo))->allActive();
        $this->render('public/home', compact('offers', 'games'));
    }

    public function offers(): void
    {
        $offers = (new Offer(Database::connection($this->config)))->publicCatalogue();
        $this->render('public/offers', compact('offers'));
    }

    public function pricing(): void
    {
        $offers = (new Offer(Database::connection($this->config)))->publicCatalogue();
        $this->render('public/pricing', compact('offers'));
    }

    public function faq(): void
    {
        $this->render('public/faq');
    }

    public function contact(): void
    {
        $this->render('public/contact');
    }

    public function game(): void
    {
        $slug = $_GET['slug'] ?? '';
        $offers = (new Offer(Database::connection($this->config)))->byGameSlug((string) $slug);
        $this->render('public/game', compact('offers', 'slug'));
    }
}
