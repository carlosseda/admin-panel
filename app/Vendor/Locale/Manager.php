<?php

namespace App\Vendor\Locale;


use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Route;
use App\Vendor\Locale\Models\LocaleTag;
use App\Vendor\Locale\Models\LocaleSeo;
use App\Vendor\Locale\Models\LocaleLanguage;
use App\Vendor\Locale\Events\TranslationsExportedEvent;

class Manager
{
    const JSON_GROUP = '_json';

    protected $app;
    protected $files;
    protected $events;
    protected $config_tag;
    protected $locales;
    protected $ignoreLocales;
    protected $ignoreFilePath;
    protected $language;

    public function __construct( Application $app, Filesystem $files, Dispatcher $events, LocaleLanguage $language)
    {
        $this->app            = $app;
        $this->files          = $files;
        $this->events         = $events;
        $this->config_tag     = $app[ 'config' ][ 'translation-manager' ];
        $this->ignoreFilePath = storage_path( '.ignore_locales' );
        $this->locales        = [];
        $this->ignoreLocales  = $this->getIgnoredLocales();
        $this->language       = $language;
    }

    protected function getIgnoredLocales()
    {
        if ( !$this->files->exists( $this->ignoreFilePath ) ) {
            return [];
        }
        $result = json_decode( $this->files->get( $this->ignoreFilePath ) );

        return ( $result && is_array( $result ) ) ? $result : [];
    }

    public function importTranslations( $replace = false, $base = null )
    {
        $counter = 0;
        $vendor = true;

        if ( $base == null ) {
            $base   = $this->app[ 'path.lang' ];
            $vendor = false;
        }

        foreach ( $this->files->directories( $base ) as $langPath ) {
            $locale = basename( $langPath );

            if ( $locale == 'vendor' ) {
                foreach ( $this->files->directories( $langPath ) as $vendor ) {
                    $counter += $this->importTranslations( $replace, $vendor );
                }
                continue;
            }

            $vendorName = $this->files->name( $this->files->dirname( $langPath ) );

            foreach ( $this->files->allfiles( $langPath ) as $file ) {
                $info  = pathinfo( $file );
                $group = $info[ 'filename' ];

                if ( in_array( $group, $this->config_tag[ 'exclude_groups' ] ) ) {
                    continue;
                }
                
                $subLangPath = str_replace( $langPath . DIRECTORY_SEPARATOR, '', $info[ 'dirname' ] );
                $subLangPath = str_replace( DIRECTORY_SEPARATOR, '/', $subLangPath );
                $langPath    = str_replace( DIRECTORY_SEPARATOR, '/', $langPath );

                if ( $subLangPath != $langPath ) {
                    $group = $subLangPath . '/' . $group;
                }

                if ( !$vendor ) {
                    $translations = \Lang::getLoader()->load( $locale, $group );
                } else {
                    $translations = include( $file );
                    $group        = "vendor/" . $vendorName;
                }

                if ( $translations && is_array( $translations ) ) {
                    foreach ( Arr::dot( $translations ) as $key => $value ) {
                        $importedTranslation = $this->importTranslation( $key, $value, $locale, $group, $replace );
                        $counter             += $importedTranslation ? 1 : 0;
                    }
                }
            }
        }

        foreach($this->files->files($this->app[ 'path.lang' ]) as $jsonTranslationFile){
            
            if ( strpos( $jsonTranslationFile, '.json' ) === false ) {
                continue;
            }

            $locale = basename( $jsonTranslationFile, '.json' );
            $group = self::JSON_GROUP;
            $translations = \Lang::getLoader()->load( $locale, '*', '*' ); 
                
            if($translations && is_array( $translations)){
                foreach ( $translations as $key => $value){
                    $importedTranslation = $this->importTranslation($key, $value, $locale, $group, $replace);
                    $counter += $importedTranslation ? 1 : 0;
                }
            }
        }

        return $counter;
    }

    public function importTranslation($key, $value, $locale, $group, $replace = false)
    {

        if ( is_array( $value ) ) {
            return false;
        }

        $value = (string) $value;

        if($group == 'routes'){

            $routes = Route::getRoutes();
            $route = $routes->getByName($key);

            $translation = LocaleSeo::firstOrNew( 
                ['language' => $locale,
                'key'    => $key,],[
                'title'  => str_replace('-', ' ', $key),
                'language' => $locale,
                'group'  => $group,
                'key'    => $key,
                'subdomain' => $route ? $route->domain() : '',
                'redirection' => 0,
                'menu' => 1,
                'sitemap' => 1,
                'active' => 1,
            ]);

            $newStatus = $translation->value === $value ? LocaleSeo::STATUS_SAVED : LocaleTag::STATUS_CHANGED;
        }else{
            $translation = LocaleTag::firstOrNew( [
                'language' => $locale,
                'group'  => $group,
                'key'    => $key,
            ] );

            $newStatus = $translation->value === $value ? LocaleTag::STATUS_SAVED : LocaleTag::STATUS_CHANGED;
        }

        if ( $newStatus !== (int) $translation->status ) {
            $translation->active = $newStatus;
        }

        if ( $replace || !$translation->value && $group == 'routes') {
            $translation->url = $value;
        }

        if ( $replace || !$translation->value && $group != 'routes') {
            $translation->value = $value;
        }

        $translation->save();

        return true;
    }

    public function findTranslations( $path = null )
    {
        $path       = $path ?: base_path();
        $groupKeys  = [];
        $stringKeys = [];
        $functions  = $this->config_tag[ 'trans_functions' ];

        $groupPattern =                              // See http://regexr.com/392hu
            "[^\w|>]" .                          // Must not have an alphanum or _ or > before real method
            '(' . implode( '|', $functions ) . ')' .  // Must start with one of the functions
            "\(" .                               // Match opening parenthesis
            "[\'\"]" .                           // Match " or '
            '(' .                                // Start a new group to match:
            '[a-zA-Z0-9_-]+' .               // Must start with group
            "([.|\/](?! )[^\1)]+)+" .             // Be followed by one or more items/keys
            ')' .                                // Close group
            "[\'\"]" .                           // Closing quote
            "[\),]";                            // Close parentheses or new parameter

        $stringPattern =
            "[^\w|>]" .                                     // Must not have an alphanum or _ or > before real method
            '(' . implode( '|', $functions ) . ')' .             // Must start with one of the functions
            "\(" .                                          // Match opening parenthesis
            "(?P<quote>['\"])" .                            // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)" . // Match any string that can be {quote} escaped
            "\k{quote}" .                                   // Match " or ' previously matched
            "[\),]";                                       // Close parentheses or new parameter

        $finder = new Finder();
        $finder->in( $path )->exclude( 'storage' )->name( '*.php' )->name( '*.twig' )->name( '*.vue' )->files();

        foreach($finder as $file){
            if(preg_match_all( "/$groupPattern/siU", $file->getContents(), $matches)){
                foreach ( $matches[ 2 ] as $key ) {
                    $groupKeys[] = $key;
                }
            }

            if ( preg_match_all( "/$stringPattern/siU", $file->getContents(), $matches ) ) {
                foreach ( $matches[ 'string' ] as $key ) {
                    if ( preg_match( "/(^[a-zA-Z0-9_-]+([.][^\1)\ ]+)+$)/siU", $key, $groupMatches ) ) {
                        continue;
                    }

                    if ( !( str_contains( $key, '::' ) && str_contains( $key, '.' ) )
                         || str_contains( $key, ' ' ) ) {
                        $stringKeys[] = $key;
                    }
                }
            }
        }

        $groupKeys  = array_unique( $groupKeys );
        $stringKeys = array_unique( $stringKeys );

        foreach ( $groupKeys as $key ) {
            list( $group, $item ) = explode( '.', $key, 2 );
            $this->missingKey( '', $group, $item );
        }

        foreach ( $stringKeys as $key ) {
            $group = self::JSON_GROUP;
            $item  = $key;
            $this->missingKey( '', $group, $item );
        }

        return count( $groupKeys + $stringKeys );
    }

    public function missingKey($namespace, $group, $key, $replace)
    {
        if($group == 'routes'){
            $languages = $this->language->get();

            foreach($languages as $language){
                LocaleSeo::firstOrCreate( [
                    'language' => $language->alias,
                    'group'  => $group,
                    'key'    => $key,
                    'url'  => isset($replace[$language->alias]) ? $replace[$language->alias] : '',
                ] );
            }
        }

        elseif(!in_array( $group, $this->config_tag[ 'exclude_groups' ] ) ) {

            $languages = $this->language->get();

            foreach($languages as $language){
                LocaleTag::firstOrCreate( [
                    'language' => $language->alias,
                    'group'  => $group,
                    'key'    => $key,
                    'value'  => isset($replace[$language->alias]) ? $replace[$language->alias] : '',
                ] );
            }
        }
    }

    public function exportTranslations($group = null, $json = false)
    {
        $basePath = $this->app[ 'path.lang' ];

        if (!is_null($group) && !$json){
            
            if (!in_array($group, $this->config_tag['exclude_groups'])){

                $vendor = false;

                if($group == '*'){
                    return $this->exportAllTranslations();
                }else{
                    if(Str::startsWith( $group, "vendor")){
                        $vendor = true;
                    }
                }

                if($group == 'routes'){
                    $tree = $this->makeTree( LocaleSeo::ofTranslatedGroup( $group )
                        ->orderByGroupKeys(Arr::get( $this->config_tag, 'sort_keys', false ) )
                        ->get() );                    
                }else{
                    $tree = $this->makeTree( LocaleTag::ofTranslatedGroup( $group )
                        ->orderByGroupKeys(Arr::get( $this->config_tag, 'sort_keys', false ) )
                        ->get() );
                }
               
                foreach($tree as $locale => $groups){

                    if(isset($groups[$group])){

                        $translations = $groups[ $group ];
                        $path = $this->app[ 'path.lang' ];

                        $locale_path = $locale . DIRECTORY_SEPARATOR . $group;

                        if($vendor) {
                            $path = $basePath . '/' . $group . '/' . $locale;                            
                            $locale_path = str_after( $group, "/" );
                        }

                        $subfolders = explode(DIRECTORY_SEPARATOR, $locale_path);
                        array_pop($subfolders);

                        $subfolder_level = '';

                        foreach ($subfolders as $subfolder){
                            
                            $subfolder_level = $subfolder_level . $subfolder . DIRECTORY_SEPARATOR;
                            $temp_path = rtrim( $path . DIRECTORY_SEPARATOR . $subfolder_level, DIRECTORY_SEPARATOR );

                            if (!is_dir($temp_path)){
                                mkdir( $temp_path, 0777, true );
                            }
                        }

                        $path = $path . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $group . '.php';

                        $output = "<?php\n\nreturn " . var_export( $translations, true ) . ";" . \PHP_EOL;

                        $this->files->put($path, $output);
                    }
                }

                if($group == 'routes'){
                    LocaleSeo::ofTranslatedGroup( $group )->update( [ 'active' => LocaleSeo::STATUS_SAVED ] );
                }else{
                    LocaleTag::ofTranslatedGroup( $group )->update( [ 'active' => LocaleTag::STATUS_SAVED ] );
                }
            }
        }

        if ( $json ) {

            if($group == 'routes'){
                $tree = $this->makeTree( LocaleSeo::ofTranslatedGroup( self::JSON_GROUP )
                        ->orderByGroupKeys(Arr::get( $this->config_tag, 'sort_keys', false ) )
                        ->get(), true );
            }else{
                $tree = $this->makeTree( LocaleTag::ofTranslatedGroup( self::JSON_GROUP )
                        ->orderByGroupKeys(Arr::get( $this->config_tag, 'sort_keys', false ) )
                        ->get(), true );
            }
            
            foreach ( $tree as $locale => $groups ) {
                if ( isset( $groups[ self::JSON_GROUP ] ) ) {
                    $translations = $groups[ self::JSON_GROUP ];
                    $path         = $this->app[ 'path.lang' ] . '/' . $locale . '.json';
                    $output       = json_encode( $translations, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE );
                    $this->files->put( $path, $output );
                }
            }

            if($group == 'routes'){
                LocaleSeo::ofTranslatedGroup( self::JSON_GROUP )->update( [ 'active' => LocaleSeo::STATUS_SAVED ] );
            }else{
                LocaleTag::ofTranslatedGroup( self::JSON_GROUP )->update( [ 'active' => LocaleTag::STATUS_SAVED ] );
            }
        }
    }

    public function exportAllTranslations()
    {
        $groups = LocaleTag::whereNotNull( 'value' )->selectDistinctGroup()->get( 'group' );

        foreach ( $groups as $group ) {
            if ( $group->group == self::JSON_GROUP ) {
                $this->exportTranslations( null, true );
            } else {
                $this->exportTranslations( $group->group );
            }
        }
    }

    protected function makeTree( $translations, $json = false )
    {
        $array = [];

        foreach ( $translations as $translation ) {
            if ( $json ) {
                $this->jsonSet( $array[ $translation->language ][ $translation->group ], $translation->key,
                    $translation->value );
            }
            elseif($translation->group == 'routes'){
                Arr::set( $array[ $translation->language ][ $translation->group ], $translation->key,
                    $translation->url );
            }
            else {
                Arr::set( $array[ $translation->language ][ $translation->group ], $translation->key,
                    $translation->value );
            }
        }

        return $array;
    }

    public function jsonSet( &$array, $key, $value )
    {
        if ( is_null( $key ) ) {
            return $array = $value;
        }
        $array[ $key ] = $value;

        return $array;
    }

    public function cleanTranslations()
    {
        LocaleTag::whereNull( 'value' )->delete();
    }

    public function truncateTranslations()
    {
        LocaleTag::truncate();
    }

    public function getLocales()
    {
        if ( empty( $this->locales ) ) {
            $locales = array_merge( [ config( 'app.locale' ) ],
                LocaleTag::groupBy( 'language' )->pluck( 'language' )->toArray() );
            foreach ( $this->files->directories( $this->app->langPath() ) as $localeDir ) {
                if ( ( $name = $this->files->name( $localeDir ) ) != 'vendor' ) {
                    $locales[] = $name;
                }
            }


            $this->locales = array_unique( $locales );
            sort( $this->locales );
        }

        return array_diff( $this->locales, $this->ignoreLocales );
    }

    public function addLocale( $locale )
    {
        $localeDir = $this->app->langPath() . '/' . $locale;

        $this->ignoreLocales = array_diff( $this->ignoreLocales, [ $locale ] );
        $this->saveIgnoredLocales();
        $this->ignoreLocales = $this->getIgnoredLocales();

        if ( !$this->files->exists( $localeDir ) || !$this->files->isDirectory( $localeDir ) ) {
            return $this->files->makeDirectory( $localeDir );
        }

        return true;
    }

    protected function saveIgnoredLocales()
    {
        return $this->files->put( $this->ignoreFilePath, json_encode( $this->ignoreLocales ) );
    }

    public function removeLocale( $locale )
    {
        if ( !$locale ) {
            return false;
        }
        $this->ignoreLocales = array_merge( $this->ignoreLocales, [ $locale ] );
        $this->saveIgnoredLocales();
        $this->ignoreLocales = $this->getIgnoredLocales();

        LocaleTag::where( 'language', $locale )->delete();
    }

    public function getConfig( $key = null )
    {
        if ( $key == null ) {
            return $this->config_tag;
        } else {
            return $this->config_tag[ $key ];
        }
    }
}
