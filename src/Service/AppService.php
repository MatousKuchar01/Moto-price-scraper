<?php

namespace App\Service;

use App\Enum\AppEnum;

class AppService
{
    /**
     * @return array
     */
    public static function getScrapedSitesURL(): array
    {
        return [AppEnum::SITE_BAZOS->value];
    }
}
