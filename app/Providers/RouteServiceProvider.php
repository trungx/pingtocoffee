<?php

namespace App\Providers;

use App\ContactFieldValue;
use App\ContactLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Reminder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Checking for validity of contact field value.
         */
        Route::bind('field', function ($value) {
            try {
                return ContactFieldValue::where('user_id', auth()->user()->id)->findOrFail($value);
            } catch (ModelNotFoundException $ex) {
                redirect('/')->send();
            }
        });

        /**
         * Checking for validity of contact log.
         */
        Route::bind('contactLog', function ($value) {
            try {
                return ContactLog::where('from_user_id', auth()->user()->id)->findOrFail($value);
            } catch (ModelNotFoundException $ex) {
                redirect('/')->send();
            }
        });

        /**
         * Checking for validity of reminder.
         */
        Route::bind('reminder', function ($value) {
            try {
                return Reminder::where('from_user_id', auth()->user()->id)->findOrFail($value);
            } catch (ModelNotFoundException $ex) {
                redirect('/')->send();
            }
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
