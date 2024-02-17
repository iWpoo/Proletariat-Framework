<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ConfigCache extends Command
{
    protected function configure()
    {
        $this->setName('config:clear')
            ->setDescription('Clear cached configs');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Added style for green color
        $style = new OutputFormatterStyle('green');
        $output->getFormatter()->setStyle('success', $style);

        // Delete cached configs
        $configCache = require __DIR__ . '/../../../config/cache.php';
        $cacheFile = __DIR__ . '/../../../' . $configCache['file']['config']['path'] . '/' . $configCache['file']['config']['name'] . '.php';

        try {
            if (file_exists($cacheFile)) {
                if (unlink($cacheFile)) {
                    $output->writeln('<success>Cached configs cleared successfully.</success>');
                } else {
                    throw new \RuntimeException('Unable to remove cached config file.');
                }
            } else {
                $output->writeln('<success>Cached configs cleared successfully.</success>');
            }
        } catch (\Exception $e) {
            // Handle exceptions and output the error message
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}