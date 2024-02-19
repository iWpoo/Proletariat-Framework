<?php

namespace Proletariat;

use Symfony\Component\Console\Application;

class Console
{
    private $application;

    public function __construct()
    {
        $this->application = new Application();
        $this->addCommands();
    }

    public function run()
    {
        $this->application->run();
    }
    
    private function addCommands(): void
    {
        $configFile = __DIR__ . '/../../config/app.php';

        if (file_exists($configFile)) {
            $commands = require $configFile;

            foreach ($commands['commands'] as $commandClass) {
                $command = new $commandClass();
                $this->application->add($command);
            }            
        } else {
            throw new \RuntimeException('App file not found.');
        }
    }
}