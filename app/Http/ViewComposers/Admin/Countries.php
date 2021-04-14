<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\DB\Country;

class Countries
{
    public $countries;

    public function __construct()
    {
        $this->countries = Country::orderBy('name', 'asc')->get();
    }

    public function compose(View $view)
    {
        $view->with('countries', $this->countries);
    }
}