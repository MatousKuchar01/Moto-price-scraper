<?php

namespace App\Command;

use App\Model\Scraper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[
    AsCommand(
        name: "app:scrape-bikes",
        description: "Hlavní vstup programu pro scrapování motorek",
    ),
]
class ScrapeBikesCommand extends Command
{
    public function __construct(private Scraper $scraper)
    {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $io = new SymfonyStyle($input, $output);

        $io->title("Spouštím scraper inzerátů z Bazoše");

        $vsechnyMotorky = [];
        $maxOffset = 100;
        $krok = 20;

        $pocetStran = $maxOffset / $krok + 1;
        $io->progressStart($pocetStran);

        for ($i = 0; $i <= $maxOffset; $i += $krok) {
            $pageParam = $i === 0 ? "" : (string) $i;

            $stranaData = $this->scraper->scrapeBazos($pageParam);
            $vsechnyMotorky = array_merge($vsechnyMotorky, $stranaData);

            $io->progressAdvance();
            usleep(500000); // 0.5 sekundy
        }

        $io->progressFinish();

        if (empty($vsechnyMotorky)) {
            $io->warning("Nebyly nalezeny žádné inzeráty.");
            return Command::FAILURE;
        }

        $radky = [];
        $poradi = 1;

        foreach ($vsechnyMotorky as $nadpis => $detaily) {
            [$cena, $url] = explode(" - ", $detaily, 2);

            $radky[] = [$poradi++, $nadpis, $cena, $url];
        }

        $io->section("Nalezené inzeráty:");
        $io->table(["#", "Název motorky", "Cena", "Odkaz (URL)"], $radky);

        $io->success(
            sprintf(
                "Scrapování dokončeno. Celkem staženo %d inzerátů.",
                count($vsechnyMotorky),
            ),
        );

        return Command::SUCCESS;
    }
}
