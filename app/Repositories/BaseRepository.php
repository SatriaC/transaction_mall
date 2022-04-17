<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Http\Request;

use App\Filters\BaseFilter;
use App\Helpers\Pagination;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    protected $env;
    protected $productionEnv = 'production';

    /**
     * Get's all datas.
     *
     * @param Builder
     * @param Request
     * @param string
     *
     * @return collection
     */
    // public function allFiltered(Builder $builder = null, Request $request = null, $filterClass)
    // {
    //     $query = BaseFilter::apply($builder, $request, $filterClass);
    //     $datas = Pagination::paginate($query, $request);
    //     return $datas;
    // }

    // public function all(Builder $builder = null, Request $request = null, $filterClass)
    // {
    //     $query = BaseFilter::apply($builder, $request, $filterClass);
    //     $datas['data'] = $query->get();
    //     // dd($query->get());
    //     // $datas = Pagination::formattingPagination($query->paginate($query->get()->count()));
    //     return $datas;
    // }

    public function all()
    {
        return $this->model->get();
    }

    /**
     * Get's a data by it's ID.
     *
     * @param uuid
     *
     * @return object
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get's a data by multiple conditions.
     *
     * @param array
     *
     * @return collection
     */
    public function getByMultipleField(array $conditions)
    {
        $data = $this->model::where(function ($q) use ($conditions) {
            foreach ($conditions as $column => $value) {
                $q->where($column, $value);
            }
        })->get();

        return $data;
    }

    /**
     * Create a data.
     *
     * @param array
     *
     * @return object
     */
    public function create(array $data)
    {
        return $this->model::create($data);
    }

    /**
     * Update a data.
     *
     * @param uuid
     * @param array
     *
     * @return object
     */
    public function update(array $data, $id)
    {
        $object = $this->model->findOrFail($id);
        return $object->update($data);
    }

    /**
     * Delete a data.
     *
     * @param uuid
     * @param array
     *
     * @return no-content
     */
    public function delete($id)
    {
        $object = $this->model::findOrFail($id);
        $object->delete();
        return 204;
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function take($take)
    {
        $this->model = $this->model->take($take);
        return $this;
    }

    public function skip($skip)
    {
        $this->model = $this->model->skip($skip);
        return $this;
    }

    public function createMany($relation, array $attributes)
    {
        return $relation->createMany($attributes);
    }

    public function updateOrCreate(array $dataToCheck, array $dataToInput)
    {
        return $this->model->updateOrCreate(
            $dataToCheck,
            $dataToInput
        );
    }

    public function getFirst()
    {
        return $this->model->get()->first();
    }

    public function getLast()
    {
        return $this->model->get()->last();
    }

}
