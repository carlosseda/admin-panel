<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Vendor\Locale\Models\LocaleTag;

class LocaleGroups
{
    public $groups;

    public function __construct()
    {
        $this->groups = LocaleTag::select('group')
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->groupBy('group')
        ->pluck('group')
        ->toArray();
    }

    public function compose(View $view)
    {
        $view->with('groups', $this->groups);
    }
}