<?php

namespace App\Vendor\Locale\Commands;

use App\Vendor\Locale\LocalizationSeo;
use App\Vendor\Locale\Traits\TranslatedRouteCommandContext;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Console\RouteListCommand;
use Symfony\Component\Console\Input\InputArgument;

class RouteTranslationsListCommand extends RouteListCommand
{
    use TranslatedRouteCommandContext;

    /**
     * @var string
     */
    protected $name = 'route:trans:list';

    /**
     * @var string
     */
    protected $description = 'List all registered routes for specific locales';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $locale = $this->argument('locale');

        if ( ! $this->isSupportedLocale($locale)) {
            $this->error("Unsupported locale: '{$locale}'.");
            return;
        }

        $this->loadFreshApplicationRoutes($locale);

        parent::handle();
    }

    /**
     * Boot a fresh copy of the application and replace the router/routes.
     *
     * @param string $locale
     * @return void
     */
    protected function loadFreshApplicationRoutes($locale)
    {
        $app = require $this->getBootstrapPath() . '/app.php';

        $key = LocalizationSeo::ENV_ROUTE_KEY;

        putenv("{$key}={$locale}");

        $app->make(Kernel::class)->bootstrap();

        putenv("{$key}=");

        $this->router = $app['router'];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['locale', InputArgument::REQUIRED, 'The locale to list routes for.'],
        ];
    }
}

