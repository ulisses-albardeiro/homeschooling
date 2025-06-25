<?php

namespace App\Http\Controllers\Plannings;

use App\Http\Controllers\Controller;
use App\Services\CurricularPlanService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CurricularPlanController extends Controller
{
    protected $curricularPlanService;

    public function __construct(CurricularPlanService $curricularPlanService)
    {
        $this->curricularPlanService = $curricularPlanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('curricular-plans/Index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('curricular-plans/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
