<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPersonalDataRequest;
use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;

class UsersController extends Controller
{
    public function __construct(protected UserService $service){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->service->list());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreationRequest $request)
    {
        return response()->json($this->service->store($request->toArray()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($this->service->show($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        return response()->json($this->service->update($id, $request->toArray()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getUserData(GetPersonalDataRequest $request)
    {
        return response()->json($this->service->getUserData($request->get('cpf')));
    }
}
