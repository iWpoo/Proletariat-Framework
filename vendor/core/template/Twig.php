<?php

namespace Proletariat\Template;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Twig implements iTemplate
{
    private static $instance;
    protected static $twig;

    public static function getInstance() 
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function init(): void
    {
        if (!self::$twig) {
            $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . "/views/");
            self::$twig = new Environment($loader);
            $this->initFunctions();
        }
    }

    public function render(string $view, array $data = []): string
    {
        $this->init();
        return self::$twig->render($view . '.twig', $data);
    }

    private function initFunctions(): void
    {
        self::$twig->addFunction(new TwigFunction('route', ['\Proletariat\Route', 'route']));
    }
}
