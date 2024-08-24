<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTypeRequest;
use App\Services\UserTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function __construct(protected UserTypeService $service){}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserTypeRequest $request): JsonResponse
    {
        return response()->json($this->service->store($request->toArray()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json($this->service->show($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        //
    }
}
