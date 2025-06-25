<?php

namespace App\Services;

use App\Repositories\CurricularPlanRepository;

class CurricularPlanService implements CurricularPlanServiceInterface
{
    protected $curricularPlanRepository;

    public function __construct(CurricularPlanRepository $curricularPlanRepository)
    {
        $this->curricularPlanRepository = $curricularPlanRepository;
    }

    public function getAll()
    {
        return $this->curricularPlanRepository->all();
    }

    public function getById($id)
    {
        return $this->curricularPlanRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->curricularPlanRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->curricularPlanRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->curricularPlanRepository->delete($id);
    }
}
