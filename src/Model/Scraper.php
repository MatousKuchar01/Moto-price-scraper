<?php

namespace App\Model;

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
     *
     */
    public function scrape()
    {
        $browser = $this->createHttpBrowser();
        $crawler = $browser->request(
            "GET",
            AppService::getScrapedSitesURL()[0],
        );

        $motorky = [];

        $crawler
            ->filter("div.inzeraty.inzeratyflex")
            ->each(function ($node) use (&$motorky) {
                $nadpisNode = $node->filter("h2.nadpis");
                $cenyNode = $node->filter('span[translate="no"]');

                if ($nadpisNode->count() > 0 && $cenyNode->count() > 0) {
                    $nadpisy = $nadpisNode->text();
                    $ceny = $cenyNode->text();

                    $motorky[$nadpisy] = $ceny;
                }
            });

        return $motorky;
    }
}
