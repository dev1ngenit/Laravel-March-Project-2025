<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Define the directory where your models are located
        $modelsDirectory = app_path('Models');

        // Scan the directory for subdirectories (e.g., 'Admin', 'HR', 'Sales')
        $directories = File::directories($modelsDirectory);

        $breadcrumbs = collect(request()->segments())->map(function ($segment, $key) use ($directories) {
            // Initialize the name variable with the segment value
            $name = ucfirst($segment);

            foreach ($directories as $directory) {
                // Get the name of the subdirectory (e.g., 'Admin', 'HR', 'Sales')
                $directoryName = basename($directory);

                // Check if the current segment matches any subdirectory name
                if (strtolower($segment) === strtolower($directoryName)) {
                    // Generate the namespace for the subdirectory's models
                    $namespace = 'App\Models\\' . $directoryName;

                    // Find the model instance using the segment value as the ID
                    $modelInstance = $namespace::find($segment);

                    // If a model instance is found, retrieve its name attribute
                    if ($modelInstance) {
                        $name = $modelInstance->name;
                    }

                    break;
                }
            }

            return [
                'url' => url(implode('/', array_slice(request()->segments(), 0, $key + 1))),
                'name' => $name,
            ];
        })->toArray();

        View::share('breadcrumbs', $breadcrumbs);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
