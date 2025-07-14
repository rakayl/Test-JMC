<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository
{
    public function __construct(protected Model $model) {}

    public function create(array $data): Model|null
    {

        return $this->model->query()->create($data);
    }

    public function getModel()
    {
        return $this->model;
    }

    public function findLatest(array $data): Model|null
    {
        return $this->model->query()->where($data)->latest()->first();
    }
 
    public function findLatestNoWhere(): Model|null
    {
        return $this->model->query()->latest()->first();
    }

    public function update(int $id, array $data): int
    {
        return $this->model->query()->where('id', $id)->update($data);
    }
      public function updateParam(array $condi, array $data): int
    {
        return $this->model->query()->where($condi)->update($data);
    }
    public function findBy(array $data, array $relation = []): Model|null
    {
        return $this->model->query()->where($data)->with($relation)->first();
    }

    public function getBy(array $data): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->where($data)->get();
    }
     public function deleteNotIn($coloumn,array $data)
    {
        return $this->model->query()->whereNotIn($coloumn,$data)->delete();
    }
  
    public function deleteBy(array $conditions)
    {
        return $this->model->query()->where($conditions)->delete();
    }
     public function statusVerifikasi(array $conditions,array $data)
    {
        return $this->model->query()->where($conditions)->update($data);
    }
    public function searchBy(array $data): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        return $this->model->query()->where($data)->cursorPaginate(10);
    }

    public function searchByOr(array $conditions): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $query = $this->model->query();

        foreach ($conditions as $column => $value) {
            $query->orWhere($column, 'LIKE', "%$value%");
        }

        return $query->cursorPaginate(10);
    }


    public function updateBy(array $conditions, array $data): int
    {
        return $this->model->query()->where($conditions)->update($data);
    }
    public function getOrderBy(array $data, $order, $conditions): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->where($data)->orderBy($order, $conditions)->get();
    }
    public function countBy(array $data)
    {
        return $this->model->query()->where($data)->count();
    }
    public function countWhereNotBy(array $data, $key, $not)
    {
        return $this->model->query()->where($data)->where($key, '!=', $not)->count();
    }
}
