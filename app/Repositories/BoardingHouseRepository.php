<?php

namespace App\Repositories;

use App\Models\BoardingHouse;
use App\Repositories\BaseRepository;

class BoardingHouseRepository extends BaseRepository
{
    public function __construct(BoardingHouse $model)
    {
        $this->model = $model;
    }

    public function index($request)
    {
        # code...
        $data = $this->model
        ->leftJoin('users','users.id', '=', 'boarding_house.user_id')
        ->orderBy('created_at', 'desc')
        ->select(['boarding_house.id','boarding_house.name','users.name as owner_name', 'boarding_house.location',
        'boarding_house.price', 'boarding_house.type', 'boarding_house.description']);

        if (isset($request->name)) {
            # code...
            $data->where('name', 'LIKE', '%'.$request->name.'%' );
            $data->orderBy('price', 'asc');
        }

        if (isset($request->location)) {
            # code...
            $data->where('location', 'LIKE', '%'.$request->location.'%' );
            $data->orderBy('price', 'asc');
        }

        if(isset($request->start_price) && isset($request->end_price)){
            $data->whereBetween('price', array($request->start_price, $request->end_price));
            $data->orderBy('price', 'asc');
        }

        return $data;
    }

    public function getById($id)
    {
        # code...
        $data = $this->model
        ->where('boarding_house.id', $id)
        ->leftJoin('users','users.id', '=', 'boarding_house.user_id')
        ->get(['boarding_house.id','boarding_house.name','users.name as owner_name', 'boarding_house.location',
        'boarding_house.price', 'boarding_house.type', 'boarding_house.description'])->last();
        return $data;
    }

    public function availability($id)
    {
        # code...
        $data = $this->model
        ->where('boarding_house.id', $id)
        ->leftJoin('users','users.id', '=', 'boarding_house.user_id')
        ->get(['boarding_house.name','users.name as owner_name', 'boarding_house.status',
        'boarding_house.qty', 'boarding_house.id'])->last();
        return $data;
    }

}
