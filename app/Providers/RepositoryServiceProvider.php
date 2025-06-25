<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CurricularPlanRepositoryInterface;
use App\Repositories\CurricularPlanRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CurricularPlanRepositoryInterface::class, CurricularPlanRepository::class);
    }
}
