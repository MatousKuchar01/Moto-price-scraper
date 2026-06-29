<?php

namespace App\Model;

use App\Enum\AppEnum;
use App\Service\AppService;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class Scraper
{
    /**
     * @return object
     */
    private function createHttpBrowser(): HttpBrowser
    {
        $client = HttpClient::create([
            "headers" => [
                "User-Agent" =>
                    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36",
            ],
        ]);

        return new HttpBrowser($client);
    }

    /**
     * @return array
     */
    public function scrapeBazos(string $pageCount = ""): array
    {
        $browser = $this->createHttpBrowser();
        $crawler = $browser->request(
            "GET",
            AppService::getBazosURL($pageCount)[0],
        );

        $motorky = [];

        $crawler
            ->filter("div.inzeraty.inzeratyflex")
            ->each(function ($node) use (&$motorky) {
                $nadpisNode = $node->filter("h2.nadpis");
                $cenyNode = $node->filter('span[translate="no"]');
                $urlNode =
                    AppEnum::PREFIX_BAZOS->value .
                    $node->filter("a")->attr("href");

                if ($nadpisNode->count() > 0 && $cenyNode->count() > 0) {
                    $nadpisy = $nadpisNode->text();
                    $ceny = $cenyNode->text();

                    $motorky[$nadpisy] = $ceny . " - " . $urlNode;
                }
            });

        return $motorky;
    }
}
