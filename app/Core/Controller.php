<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    protected function render(string $template, array $data = []): void
    {
        View::render($template, array_merge($data, [
            'appConfig' => $this->config,
            'currentUser' => Auth::user(),
            'csrfToken' => Csrf::token(),
        ]));
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
