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
}
