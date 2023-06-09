<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Tag\TagRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function getModel()
    {
        return Tag::class;
    }

    public function getTags($config)
    {
        return $this->model->withCount(['products'])
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
