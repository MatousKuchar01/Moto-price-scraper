<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: "app:scrape-bikes", description: "Hlavní vstup programu")]
class ScrapeBikesCommand extends Command
{
    /**
     * php bin/console app:scrape-bikes
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $io = new SymfonyStyle($input, $output);

        // 1. Interaktivní vstup
        $brand = $io->ask("Jakou značku motorky hledáme?", "Yamaha");

        $io->success("Hotovo!");
        return Command::SUCCESS;
    }
}
