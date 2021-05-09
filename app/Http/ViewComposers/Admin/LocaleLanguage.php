<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Vendor\Locale\Models\LocaleLanguage as DBLocaleLanguage;

class LocaleLanguage
{
    static $composed;

    public function __construct(DBLocaleLanguage $localizations)
    {
        $this->localizations = $localizations; 
    }

    public function compose(View $view)
    {
        if(static::$composed)
        {
            return $view->with('localizations', static::$composed);
        }

        static::$composed = $this->localizations->orderBy('name', 'asc')->get();

        $view->with('localizations', static::$composed);
    }
}