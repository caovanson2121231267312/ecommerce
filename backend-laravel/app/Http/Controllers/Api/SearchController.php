<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductWithRelationResource;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(ProductRepository $productRepo)
    {
        $this->product = $productRepo;
    }

    public function index(Request $request)
    {
        $keywords = $request->q;
        $products =  $this->product->search($keywords);

        return response()->json([
            "data" => ProductWithRelationResource::collection($products),
        ]);
    }
}
