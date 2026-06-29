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
}
