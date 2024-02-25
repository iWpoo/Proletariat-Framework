<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartServer extends Command
{
    protected function configure()
    {
        $this->setName('server:start')
            ->setDescription('Start the PHP built-in server on localhost:8000');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int    
    {
        // Get the public directory where your index.php is located
        $publicDirectory = __DIR__ . '/../../../';

        // Build the command to start the PHP built-in server
        $command = sprintf('php -S localhost:8000 -t %s', $publicDirectory);

        $output->writeln('<info>Server started at http://localhost:8000</info>');

        // Execute the command using passthru() to show real-time output
        passthru($command, $exitCode);   
        
        if ($exitCode === 0) {
            // If the command exits successfully
            $output->writeln('<info>Server started at http://localhost:8000</info>');
            return Command::SUCCESS;
        } else {
            // If there was an error, output an error message
            $output->writeln('<error>Error starting the server</error>');
            return Command::FAILURE;
        }
    }
}
