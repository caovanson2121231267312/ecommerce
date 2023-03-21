<?php

namespace App\Repositories\ProductInfor;

use App\Models\ProductInfor;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\ProductInfor\ProductInforRepositoryInterface;

class ProductInforRepository extends BaseRepository implements ProductInforRepositoryInterface
{
    public function getModel()
    {
        return ProductInfor::class;
    }
}
