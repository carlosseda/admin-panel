<?php

namespace App\Models\DB;

use App\Vendor\Locale\Models\Locale;
use App\Vendor\Locale\Models\LocaleSlugSeo;
use App\Vendor\Image\Models\ImageResize;
use App;

class Faq extends DBModel
{

    protected $table = 't_faqs';
    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }
    
    public function locale()
    {
        return $this->hasMany(Locale::class, 'key')->where('rel_parent', 'faqs')->where('language', App::getLocale());
    }

    public function seo()
    {
        return $this->hasOne(LocaleSlugSeo::class, 'key')->where('rel_parent', 'faqs')->where('language', App::getLocale());
    }

    public function images_featured()
    {
        return $this->hasMany(ImageResize::class, 'entity_id')->where('grid', 'preview')->where('content', 'featured')->where('entity', 'faqs');
    }

    public function image_featured_desktop()
    {
        return $this->hasOne(ImageResize::class, 'entity_id')->where('grid', 'desktop')->where('content', 'featured')->where('entity', 'faqs')->where('language', App::getLocale());
    }

    public function image_featured_mobile()
    {
        return $this->hasOne(ImageResize::class, 'entity_id')->where('grid', 'mobile')->where('content', 'featured')->where('entity', 'faqs')->where('language', App::getLocale());
    }

}
