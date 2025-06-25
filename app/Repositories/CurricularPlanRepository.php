<?php

namespace App\Repositories;

use App\Models\CurricularPlan;
use App\Repositories\CurricularPlanRepositoryInterface;

class CurricularPlanRepository implements CurricularPlanRepositoryInterface
{
    public function all()
    {
        return CurricularPlan::all();
    }

    public function find($id)
    {
        return CurricularPlan::findOrFail($id);
    }

    public function create(array $data)
    {
        return CurricularPlan::create($data);
    }

    public function update($id, array $data)
    {
        $plan = CurricularPlan::findOrFail($id);
        $plan->update($data);
        return $plan;
    }

    public function delete($id)
    {
        return CurricularPlan::destroy($id);
    }
}
