<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Repositories\EloquentRepository;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function createProduct(array $attributes, array $detail, array $tags)
    {
        $product = $this->model->create($attributes);

        $product->tags()->attach($tags);

        $product->details()->createMany($detail);

        return $product;
    }

    public function getProduct($request)
    {
        $perPage = 10;
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $perPage;
        $categoryId = DB::table('categories')->where('name', 'like', '%' . $request->category_id . '%')->value('id');

        $data = $this->model
            ->select('*', DB::raw('(SELECT AVG(rate) FROM rates WHERE rates.product_id = products.id) as avg_rate'))
            // ->where('sale', '>', 20)
            ->withCount(['rates'])
            ->where('category_id', '=', $categoryId)
            ->orderBy('updated_at', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        return $data;
    }

    public function getProductWithHotSale()
    {
        return $this->model
            ->select('*', DB::raw('(SELECT AVG(rate) FROM rates WHERE rates.product_id = products.id) as avg_rate'))
            ->where("sale", ">", 20)->withCount(['rates'])
            ->latest()->take(10)->get();
    }

    public function getProducts($config)
    {
        $relations =  ['category', 'tags', 'details', 'brand', 'user'];
        return $this->model
            ->orderBy($config['order_by'], $config['mode'])
            ->select('*', DB::raw('(SELECT AVG(rate) FROM rates WHERE rates.product_id = products.id) as avg_rate'))
            ->when($relations, function ($q) use ($relations) {
                return $q->with($relations)->withCount(['rates']);
            })
            ->when($config['search'], function ($q) use ($config) {
                return $q->where($config['search'], "like", "%" . $config['key'] . "%");
            })
            ->paginate($config['page_size'] ?? config('setting.default_page_size'));
    }

    public function search(string $keywords)
    {
        $relations =  ['category', 'tags', 'details', 'brand', 'user'];
        return $this->model
            ->select('*', DB::raw('(SELECT AVG(rate) FROM rates WHERE rates.product_id = products.id) as avg_rate'))
            ->when($relations, function ($q) use ($relations) {
                return $q->with($relations)->withCount(['rates']);
            })
            ->where('name', "like", "%" . $keywords . "%")->latest()
            ->get();
    }
}
