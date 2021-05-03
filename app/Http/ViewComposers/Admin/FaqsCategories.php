<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\DB\FaqCategory;

class FaqsCategories
{
    static $composed;

    public function __construct(FaqCategory $faqs_categories)
    {
        $this->faqs_categories = $faqs_categories;
    }

    public function compose(View $view)
    {

        if(static::$composed)
        {
            return $view->with('faqs_categories', static::$composed);
        }

        static::$composed = $this->faqs_categories->where('active', 1)->orderBy('name', 'asc')->get();

        $view->with('faqs_categories', static::$composed);

    }
}

