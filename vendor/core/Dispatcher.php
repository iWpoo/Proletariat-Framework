<?php

namespace Core;

use DI\Container;

class Dispatcher
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getPage(Track $track)
    {
        $className = ucfirst($track->controller) . 'Controller';
        $fullName = "\\App\\Controllers\\$className";

        try {
            $controller = $this->container->get($fullName);

            if (method_exists($controller, $track->action)) {
                $result = $controller->{$track->action}($track->params);

                if ($result) {
                    return $result;
                }
            } else {
                echo "Метод <b>{$track->action}</b> не найден в классе $fullName."; 
                die();
            }
        } catch (\Exception $error) {
            echo $error->getMessage(); 
            die();
        }
    }
}
