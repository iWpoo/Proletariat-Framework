<?php

namespace Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

abstract class Controller
{
    protected static $twig;

    protected function initTwig(): void
    {
        if (!self::$twig) {
            $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . "/views/");
            self::$twig = new Environment($loader);
            $this->initTwigFunctions();
        }
    }

    protected function render(string $view, array $data = []): string
    {
        $this->initTwig();
        return self::$twig->render($view . '.twig', $data);
    }

    protected function initTwigFunctions(): void
    {
        self::$twig->addFunction(new TwigFunction('route', ['\Core\Route', 'route']));
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
