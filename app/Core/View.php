<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = __DIR__ . '/../Views/' . $template . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(404);
            exit('View not found: ' . htmlspecialchars($template));
        }
        include __DIR__ . '/../Views/layouts/header.php';
        include $viewFile;
        include __DIR__ . '/../Views/layouts/footer.php';
    }
}
