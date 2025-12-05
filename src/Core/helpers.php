<?php

use Core\Application;

if (!function_exists('app')) {
    function app(): ?Application {
        return Application::getInstance();
    }
}

if (!function_exists('app_url')) {
    function app_url(): string {
        return 'http://localhost:8000';
    }
}

if (!function_exists('route')) {
    function route(string $routeName): string {
        if ($routeName == 'home') {
            return app_url();
        }

        return app_url().'/'.str_replace('.', '/', $routeName);
    }
}

if (!function_exists('view')) {
    function view(string $view, array $params = []): string {
        return app()
            ->twig
            ->render(
                str_replace('.', '/', $view) . '.html.twig',
                $params
            );
    }
}