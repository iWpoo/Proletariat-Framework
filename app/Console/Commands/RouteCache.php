<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class RouteCache extends Command
{
    protected function configure()
    {
        $this->setName('route:clear')
            ->setDescription('Clear cached routes');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Added style for green color
        $style = new OutputFormatterStyle('green');
        $output->getFormatter()->setStyle('success', $style);

        // Delete cached routes
        $configCache = require __DIR__ . '/../../../config/cache.php';
        $cacheFile = __DIR__ . '/../../../' . $configCache['file']['route']['path'] . '/' . $configCache['file']['route']['name'] . '.cache';

        try {
            if (file_exists($cacheFile)) {
                if (unlink($cacheFile)) {
                    $output->writeln('<success>Cached routes cleared successfully.</success>');
                } else {
                    throw new \RuntimeException('Unable to remove cached route file.');
                }
            } else {
                $output->writeln('<success>Cached routes cleared successfully.</success>');
            }
        } catch (\Exception $e) {
            // Handle exceptions and output the error message
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}