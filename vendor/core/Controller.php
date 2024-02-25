<?php

namespace Proletariat;

use Proletariat\Template\Twig;

abstract class Controller
{
    protected function render(string $view, array $data = []): string
    {
        $template = Twig::getInstance();
        return $template->render($view, $data);
    }
}
