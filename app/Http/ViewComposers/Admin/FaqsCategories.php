<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Models\DB\FaqCategory as FaqCategory;

class FaqsCategories
{
    public $categories;

    public function __construct()
    {
        $this->faqs_categories = FaqCategory::orderBy('name', 'asc')->get();
    }

    public function compose(View $view)
    {
        $view->with('faqs_categories', $this->faqs_categories);
    }
}