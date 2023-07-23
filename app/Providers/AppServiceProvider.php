<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Blade::directive('date', function (string $expression) {
            // return Carbon::parse($expression)->locale( App::currentLocale() ) ;
            return "<?php echo ($expression)->format('M-d-Y'); ?>";
        });
    }
}
