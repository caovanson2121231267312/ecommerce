<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }
}