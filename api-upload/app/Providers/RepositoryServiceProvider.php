<?php

namespace App\Providers;

use App\Repositories\UploadRepository;
use App\Repositories\UploadRepositoryEloquent;
use App\Repositories\Mongo\RecordRepository;
use App\Repositories\Mongo\RecordRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UploadRepository::class, UploadRepositoryEloquent::class);
        $this->app->bind(RecordRepository::class, RecordRepositoryEloquent::class);
    }
}
