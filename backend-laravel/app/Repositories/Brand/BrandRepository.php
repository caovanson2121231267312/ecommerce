<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Brand\BrandRepositoryInterface;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function getModel()
    {
        return Brand::class;
    }

    public function getBrands($config)
    {
        return $this->model->withCount(['categories', 'products'])
            ->orderBy($config['order_by'], $config['mode'])
            ->when($config['search'], function ($q) use ($config) {
                return $q->where($config['search'], "like", "%{$config['key']}%");
            })
            ->paginate($config['page_size'] ?? config('setting.default_page_size'));
    }

    public function findWithRelation(int $id, array $relations)
    {
        return $this->model->find($id)->loadCount($relations);
    }
}