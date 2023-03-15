<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\ProductWithRelationResource;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductImage\ProductImageRepository;
use App\Models\Product;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use DB;

class ProductController extends Controller
{
    public function __construct(
        ProductRepository $productRepo,
        ProductImageRepository $productImageRepo,
    ){
        $this->product = $productRepo;
        $this->imgProduct = $productImageRepo;
    }

    public function index(Request $request)
    {
        $config = [
            "page" => $request->page ?? null,
            "page_size" => $request->page_size ?? null,
            "order_by" => $request->order_by ?? "id",
            "mode" => $request->mode ?? "ASC",
            "search" => $request->search ?? null,
            "key" => $request->key ?? null,
        ];
        try {
            $products = $this->product->getWithConfig($config);

            return ProductResource::collection($products);
        } catch (QueryException $exception){

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                    "name" => $request->name,
                    "description" => $request->description,
                    "detail" => $request->detail,
                    "price" => $request->price,
                    "note" => $request->note,
                    "category_id" => $request->category_id,
                    "sale" => $request->sale,
                    "time_limit" => $request->time_limit,
                    "view" => 0,
                ];

            if ($file = $request->file('image')){
                $fileName = $file->getClientOriginalName();
                $fileExt = $file->getClientOriginalExtension();
                $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . Carbon::now()->timestamp . '.' . $fileExt;
                $data['image'] = $fileName;
                $file->move('images/products' , $fileName);
            }

            $images1 = array();

            if ($files = $request->file('files')){
                foreach($files as $value) {
                    $fileName = $value->getClientOriginalName();
                    $fileExt = $value->getClientOriginalExtension();
                    $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . Carbon::now()->timestamp;
                    array_push($images1, [
                        'image' => $fileName. '.' . $fileExt, 
                        'title' => $fileName,
                    ]);
                    $value->move('images/products' , $fileName. '.' . $fileExt);
                }
            }

            $product = $this->product->create($data);

            $product->tags()->attach($request->tags);

            // $product->images()->associate($images1);
 
            // $product->images()->attach($images1);
            $product1 = $this->imgProduct->product()->associate($images); 
            
            // $product->attach($request->tags);
            $product->with(["tags","images"])->get();
            
            DB::commit();
            dd($product1);
            dd($product);

            return response()->json([
                'message' => "create success",
                'data' => new ProductWithRelationResource($product),
            ], 200);
        } catch (QueryException $exception){
            DB::rollBack();
            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->product->find($id);

            return response()->json([
                'data' => new ProductResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_mdoel_not_found'),
            ], 500);
        }
    }


    public function update(ProductRequest $request, $id)
    {
        try {
            $data = [
                "title" => $request->title,
                "content" => $request->content,
                "sale" => $request->sale,
                "time_limit" => $request->time_limit,
            ];

            $product = $this->product->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new ProductResource($Product),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have error :' . $exception->getMessage()),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $this->product->delete($id);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => __('have error :' . $th->getMessage()),
            ], 500);
        }

        return response()->json([
            'message' => __('delete_success'),
        ], 200);
    }
}
