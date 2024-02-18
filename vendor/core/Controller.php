<?php

namespace Core;

use Core\Services\Twig;

abstract class Controller
{
    protected function render(string $view, array $data = []): string
    {
        $template_type = Env::get('TEMPLATE_DRIVER');
        switch ($template_type) {
            case 'twig':
                return Twig::getInstance()->render($view, $data);
            default: 
                throw new \Exception('Undefined database type: ' . $template_type);
        }
    }

    protected function redirect($to = null): self
    {
        if ($to !== null) {
            header("Location: $to");
            exit();
        }

        return $this;
    }

    protected function route($name): void
    {
        $path = \Core\Route::route($name);
        $this->redirect($path);
    }

    protected function back(): void
    {
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
