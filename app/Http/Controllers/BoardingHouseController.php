<?php

namespace App\Http\Controllers;

use App\Services\BoardingHouseService;
use Illuminate\Http\Request;

class BoardingHouseController extends Controller
{

    protected $service;

    public function __construct(
        BoardingHouseService $service
    )
    {
        $this->service = $service;
        $this->middleware('role:owner', ['only' => ['store', 'update', 'destroy']]);
        $this->middleware('role:user', ['only' => ['availability']]);
    }

    public function index(Request $request)
    {
        # code...
        return $this->service->index($request);
    }

    public function store(Request $request)
    {
        # code...
        return $this->service->store($request);
    }

    public function update(Request $request, $id)
    {
        # code...
        return $this->service->update($request, $id);
    }

    public function show($id)
    {
        # code...
        return $this->service->show($id);
    }

    public function availability($id)
    {
        # code...
        return $this->service->availability($id);
    }

    public function destroy($id)
    {
        # code...
        return $this->service->destroy($id);
    }
}
