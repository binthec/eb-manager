<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // app/Helpers 以下のファイルをすべてインクルードする
        $allHelperFiles = glob(app_path('Helpers') . '/*.php');
        foreach ($allHelperFiles as $key => $helperFile) {
            require_once $helperFile;
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
