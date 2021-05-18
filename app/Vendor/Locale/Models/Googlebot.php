<?php 

namespace App\Vendor\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class Googlebot extends Model{

    protected $table = 't_googlebot';
    protected $guarded = [];

    public function sitemap()
    {
        return $this->belongsTo(Sitemap::class, 'sitemap_id');
    }

}
