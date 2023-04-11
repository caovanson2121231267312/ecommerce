<?php

namespace App\Repositories\Role;

use App\Repositories\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function findWithRelationData(int $id, array $relations, array $data);
}