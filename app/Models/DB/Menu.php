<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;
use App\Vendor\Locale\Locale;

class Menu extends DBModel
{
    protected $table = 't_menu';

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function parent_items()
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id');
    }
}
