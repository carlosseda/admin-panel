<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;
use App\Vendor\Locale\Models\LocaleSeo;

class MenuItem extends DBModel
{
    protected $table = 't_menu_item';

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('children');
    }

    public function locale()
    {
        return $this->hasMany(Locale::class, 'key')->where('rel_parent', 'menus.item.form');
    }

    public function localeSeo()
    {
        return $this->hasOne(LocaleSeo::class, 'id', 'locale_seo_id');
    }
}
