<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\DB\Country;

class Countries
{
    static $composed;

    public function __construct(Country $countries)
    {
        $this->countries = $countries;
    }

    public function compose(View $view)
    {
        if(static::$composed)
        {
            return $view->with('countries', static::$composed);
        }

        static::$composed = $this->countries->orderBy('name', 'asc')->get();

        $view->with('countries', static::$composed);
    }
}