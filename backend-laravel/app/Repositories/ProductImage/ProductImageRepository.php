<?php

namespace App\Repositories\ProductImage;

use App\Models\ImagesProduct;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\ProductImage\ProductImageRepositoryInterface;

class ProductImageRepository extends BaseRepository implements ProductImageRepositoryInterface
{
    public function getModel()
    {
        return ImagesProduct::class;
    }
}