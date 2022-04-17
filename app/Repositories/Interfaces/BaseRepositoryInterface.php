<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    /**
     * Get's all datas.
     *
     * @param Builder
     * @param Request
     * @param string
     * 
     * @return collection
     */
    // public function allFiltered(Builder $builder, Request $request, $filterClass);

    public function all();

    /**
     * Get's a data by it's ID.
     *
     * @param uuid
     * 
     * @return object
     */
    public function getById($id);

    /**
     * Get's a data by multiple conditions.
     * 
     * @param array
     * 
     * @return collection
     */
    public function getByMultipleField(array $conditions);

    /**
     * Create a data.
     * 
     * @param array
     * 
     * @return object
     */
    public function create(array $data);

    /**
     * Update a data.
     * 
     * @param uuid
     * @param array
     * 
     * @return object
     */
    public function update(array $data, $id);
    
    /**
     * Delete a data.
     * 
     * @param uuid
     * @param array
     * 
     * @return no-content
     */
    public function delete($id);
}