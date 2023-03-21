<?php

namespace App\Repositories;

use App\Helpers\Helpers;
use Illuminate\Support\Str;
use App\Repositories\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getWithConfig($config)
    {
        return $this->model
            ->orderBy($config['order_by'], $config['mode'])
            ->when($config['search'], function ($q) use ($config) {
                return $q->where($config['search'], "like", "%" . $config['key'] . "%");
            })->paginate($config['page_size'] ?? config('setting.default_page_size'));
    }

    public function getAllWithPaginate(int $paginateNumber, $orderBy = 'id', $order = 'asc')
    {
        return $this->model->orderBy($orderBy, $order)->paginate($paginateNumber)->withQueryString();
    }

    public function getAllWithRelationPaginate(int $perPage, array $relations)
    {
        return $this->model->with($relations)->paginate($perPage)->withQueryString();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByWhere(array $where, $orderBy = 'id', $order = 'asc')
    {
        return $this->model->where($where)->orderBy($orderBy, $order)->get();
    }

    public function whereNotIn(string $condition, array $attributes)
    {
        return $this->model->whereNotIn($condition, $attributes)->get();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        $result = $this->model->findOrFail($id);

        $result->update($attributes);

        return $result;
    }

    public function delete(int $id)
    {
        $result = $this->model->findOrFail($id);

        return $result->delete();
    }

    public function getRecordByWhereIn(string $condition, array $attributes)
    {
        return $this->model->whereIn($condition, $attributes)->get();
    }

    public function getRandomRecords(int $limitSongNumber, array $relations = [])
    {
        $records = $this->model
            ->with($relations)
            ->inRandomOrder()
            ->limit($limitSongNumber)
            ->get();

        $records->each(function ($record) {
            $record->rand_color = Helpers::randomColor();
        });

        return $records;
    }

    public function findByWhereLike(array $where, array $relations = [])
    {
        $builder = $this->model;
        foreach ($where as $key => $condition) {
            $query = 'UPPER(' . $condition[0] . ') LIKE \'%' . Str::upper($condition[1]) . '%\'';
            $builder = $builder->whereRaw($query);
        }

        $records = $builder->with($relations)->get();

        $records->each(function ($record) {
            $record->rand_color = Helpers::randomColor();
        });

        return $records;
    }

    public function whereBetween(string $condition, array $attributes)
    {
        return $this->model->whereBetween($condition, $attributes)->get();
    }
}
