<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepositoryInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUsers($config)
    {
        return $this->model->with(['roles'])
            ->orderBy($config['order_by'], $config['mode'])
            ->when($config['search'], function ($q) use ($config) {
                return $q->where($config['search'], "like", "%{$config['key']}%");
            })
            ->paginate($config['page_size'] ?? config('setting.default_page_size'));
    }

    public function get_technical_support()
    {
        $data = $this->model->with('roles')->whereHas('roles', function ($query) {
            $query->where('name', 'Technical support');
        })->get();

        return $data;
    }

    public function get_users_chat($id)
    {
        $data = $this->model->where("messages.id", $id)->withCount('messages')
            ->orderByDesc('messages_count')
            ->orderByDesc('messages.created_at')
            ->get();

        return $data;
    }

    public function getAllWithRoles(int $paginateNumber, $orderBy = 'id', $order = 'desc')
    {
        return $this->model->with("roles")->orderBy($orderBy, $order)->paginate($paginateNumber)->withQueryString();
    }

    public function findWithRelation(int $id, array $relations)
    {
        return $this->model->findOrFail($id)->load($relations);
    }

    public function findWithRelationData(int $id, array $relations, array $data)
    {
        $data = $this->model->find($id)->load($data)->loadCount($relations);
        return $data;
    }

    public function updateUser($id, $attributes, array $roleIds)
    {
        $user = $this->update($id, $attributes);
        $user->syncRoles($roleIds);

        return $user;
    }
}
