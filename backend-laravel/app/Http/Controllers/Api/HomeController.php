<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Exception;

class HomeController extends Controller
{
    public $product;

    public function __construct(ProductRepository $productRepo)
    {
        $this->product = $productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->getProduct();
        return response()->json(
            $products
        );
    }

    public function product($slug)
    {
        try {
            $products = Product::findBySlugOrFail($slug)->load(['category', 'tags', 'details']);

            return response()->json(
                $products
            );
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
                "code" => 500
            ], 500);
        }
    }

    public function categories()
    {
        $data = Category::with(['brands'])->get();
        
        return response()->json($data);
    }

    public function cart(Request $request)
    {
        $arr = array();
        foreach ($request->cart as $value) {
            array_push($arr, $value['id']);
        }
        try {
            $products = Product::whereIn("id", $arr)->with(['category'])->get();

            return response()->json([
                "data" => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
                "code" => 500
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}