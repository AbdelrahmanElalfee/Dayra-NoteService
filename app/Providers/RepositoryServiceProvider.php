<?php

namespace App\Providers;

use App\Repositories\NoteRepository;
use App\Repositories\NoteRepositoryInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
    public function register(): void
    {
        $this->app->bind(
            NoteRepositoryInterface::class,
            NoteRepository::class
        );
    }


}
