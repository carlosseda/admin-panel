<?php

namespace App\Vendor\Locale\Facades;

use Illuminate\Support\Facades\Facade;

class LocalizationSeo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'localizationseo';
    }
}
