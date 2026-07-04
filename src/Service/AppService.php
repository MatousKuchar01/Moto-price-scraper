<?php

namespace App\Service;

use App\Enum\AppEnum;

class AppService
{
    /**
     * @return array
     */
    public static function getBazosURL(string $pageCount = ""): array
    {
        $url = AppEnum::PREFIX_BAZOS->value . "/" . $pageCount;

        if ($pageCount != "") {
            $url .= "/?strana=" . $pageCount;
        }

        return [$url];
    }

    /**
     * @param $radky
     * @return void
     */
    public function seradit(array &$radky): void
    {
        usort($radky, function ($a, $b) {
            $cenaA = (int) preg_replace("/[^0-9]/", "", $a[2]);
            $cenaB = (int) preg_replace("/[^0-9]/", "", $b[2]);

            return $cenaA <=> $cenaB;
        });
    }

    /**
     * @return string Obarvený řetězec pro Symfony CLI
     */
    public function color(string $cena): string
    {
        $cenaCislo = (int) preg_replace("/[^0-9]/", "", $cena);

        if ($cenaCislo === 0) {
            return "<fg=cyan;options=blink>{$cena}</>";
        }

        switch (true) {
            case $cenaCislo <= 20000:
                return "<fg=green;options=bold>{$cena}</>";
            case $cenaCislo <= 60000:
                return "<fg=green>{$cena}</>";
            case $cenaCislo <= 150000:
                return "<fg=yellow>{$cena}</>";
            case $cenaCislo <= 300000:
                return "<fg=red>{$cena}</>";
            default:
                return "<fg=white;bg=red;options=bold> {$cena} </>";
        }
    }
}
