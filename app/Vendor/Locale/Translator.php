<?php 

namespace App\Vendor\Locale;

use Illuminate\Contracts\Translation\Loader;
use Illuminate\Translation\Translator as LaravelTranslator;
use Illuminate\Events\Dispatcher;

class Translator extends LaravelTranslator {

    /** @var  Dispatcher */
    protected $events;

    /**
     * Get the translation for the given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */

    public function __construct(Loader $loader, $locale)
    {
        $this->loader = $loader;
        $this->locale = $locale;
    }

    public function get($key, array $replace = array(), $locale = null, $fallback = true)
    {
        // Get without fallback
        $result = parent::get($key, $replace, $locale, false);

        if(!empty($replace) && empty($result)){

            $this->notifyMissingKey($key, $replace);
            
            // Reget with fallback
            $result = parent::get($key, $replace, $locale, $fallback);
        }

        return $result;
    }

    public function trans($key, array $replace = [], $locale = null, $fallback = true)
    {       

        $result = parent::get($key, $replace, $locale, $fallback);
        
        return $result;
    }

    public function setTranslationManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    protected function notifyMissingKey($key, $replace)
    {
        list($namespace, $group, $item) = $this->parseKey($key);

        if($this->manager && $namespace === '*' && $group && $item ){
            $this->manager->missingKey($namespace, $group, $item, $replace);
            $this->manager->exportTranslations($group);   
        }
    }
}
