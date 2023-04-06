<?php

namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;
use App\Repositories\BaseRepository;
use App\Repositories\Permission\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function getModel()
    {
        return Permission::class;
    }

    public function getPermissions($config)
    {
        return $this->model->withCount(['roles', 'users'])
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