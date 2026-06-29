<?php

namespace App\Command;

use App\Model\Scraper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: "app:scrape-bikes", description: "Hlavní vstup programu")]
class ScrapeBikesCommand extends Command
{
    public function __construct(private Scraper $scraper)
    {
        parent::__construct();
    }

    /**
     * php bin/console app:scrape-bikes
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        for ($i = 0; $i <= 100; $i += 20) {
            $pageParam = $i === 0 ? "" : (string) $i;
            dump($this->scraper->scrapeBazos($pageParam));
        }

        $io = new SymfonyStyle($input, $output);
        return Command::SUCCESS;
    }
}
