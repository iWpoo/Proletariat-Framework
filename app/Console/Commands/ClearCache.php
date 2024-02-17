<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ClearCache extends Command
{
    protected function configure()
    {
        $this->setName('cache:clear')
            ->setDescription('Clear cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Added style for green color
        $style = new OutputFormatterStyle('green');
        $output->getFormatter()->setStyle('success', $style);

        // Delete cached configs
        $configCache = require __DIR__ . '/../../../config/cache.php';
        $cacheDir = __DIR__ . '/../../../storage/cache';

        try {
            if (is_dir($cacheDir)) {
                if (rmdir($cacheDir)) {
                    $output->writeln('<success>Cache cleared successfully.</success>');
                } else {
                    throw new \RuntimeException('Unable to remove cache directory.');
                }
            } else {
                $output->writeln('<success>Cache cleared successfully.</success>');
            }
        } catch (\Exception $e) {
            // Handle exceptions and output the error message
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}