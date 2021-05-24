<?php

namespace App\Http\ViewComposers\Admin;

use Illuminate\View\View;
use App\Vendor\Locale\Models\LocaleTag;

class LocaleGroups
{
    public $groups;

    public function __construct()
    {
        $groups = LocaleTag::select('group')->where('group', 'not like', 'admin/%')->groupBy('group')->get();

        $this->groups = $groups->each(function($item, $key){
            $item->name = $item->group;
            $item->id = $key;
        });
    }

    public function compose(View $view)
    {
        $view->with('groups', $this->groups);
    }
}