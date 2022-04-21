<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    protected $service;

    public function __construct(
        TransactionService $service
    )
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        # code...
        return $this->service->store($request);
    }

    public function show($id)
    {
        # code...
        return $this->service->show($id);
    }
}
