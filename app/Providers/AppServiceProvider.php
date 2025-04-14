<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

use App\Repositories\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Services\AuthServiceInterface;
use App\Services\AuthService;

use App\Repositories\EmailRepositoryInterface;
use App\Repositories\EmailRepository;
use App\Services\EmailServiceInterface;
use App\Services\EmailService;

use App\Repositories\PasswordRepositoryInterface;
use App\Repositories\PasswordRepository;
use App\Services\PasswordServiceInterface;
use App\Services\PasswordService;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\UserServiceInterface;
use App\Services\UserService;

use App\Repositories\ProfileRepositoryInterface;
use App\Repositories\ProfileRepository;
use App\Services\ProfileServiceInterface;
use App\Services\ProfileService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        $this->app->bind(EmailRepositoryInterface::class, EmailRepository::class);
        $this->app->bind(EmailServiceInterface::class, EmailService::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        
        $this->app->bind(PasswordRepositoryInterface::class, PasswordRepository::class);
        $this->app->bind(PasswordServiceInterface::class, PasswordService::class);

        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
