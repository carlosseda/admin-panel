<?php

namespace App\Http\ViewComposers\Front;

use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use App\Vendor\Image\Models\ImageResized;

class Logo
{
    static $composed;

    public function __construct(ImageResized $image, Agent $agent)
    {
        $this->image = $image;
        $this->agent = $agent;
    }

    public function compose(View $view)
    {
        if(static::$composed)
        {
            return $view->with('logo', static::$composed);
        }

        if ($this->agent->isMobile()) {
            static::$composed = $this->image->where('grid', 'mobile')->where('content', 'logo')->where('language', app()->getLocale())->first();
        }

        if ($this->agent->isDesktop()) {
            static::$composed = $this->image->where('grid', 'desktop')->where('content', 'logo')->where('language', app()->getLocale())->first();
        }

        $view->with('logo', static::$composed);
    }
}