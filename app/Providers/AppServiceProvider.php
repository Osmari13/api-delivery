<?php

namespace App\Providers;

use App\Models\User;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityRequirement;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Facades\Gate;
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
        Scramble::configure()
        ->withDocumentTransformers(function (OpenApi $openApi) {
            $openApi->components->securitySchemes['tenant'] = SecurityScheme::apiKey('header', 'X-Tenant');
            $openApi->components->securitySchemes['bearer'] = SecurityScheme::http('bearer');

            $openApi->security[] = new SecurityRequirement([
                'tenant' => [],
                'bearer' => [],
            ]);
        });
        Gate::define('viewApiDocs', function (User $user) {
            // return in_array($user->email, ['admin@app.com']); // Se puede especificar que usuarios pueden ver la documentacion
            return true;
        });
    }
}
