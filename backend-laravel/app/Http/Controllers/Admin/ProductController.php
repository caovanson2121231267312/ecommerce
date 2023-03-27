<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\ProductI;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductInfor\ProductInforRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\Admin\ProductWithRelationResource;

class ProductController extends Controller
{
    public $product;
    public $productDetail;

    public function __construct(
        ProductRepository $productRepo,
        ProductInforRepository $productDetail,
    ) {
        $this->middleware('auth:api');
        $this->product = $productRepo;
        $this->productDetail = $productDetail;
    }

    public function index(Request $request)
    {
        $config = [
            "page" => $request->page ?? null,
            "page_size" => $request->page_size,
            "order_by" => $request->order_by ?? "id",
            "mode" => $request->mode ?? "ASC",
            "search" => $request->search ?? null,
            "key" => $request->key ?? null,
        ];
        try {
            $products = $this->product->getWithConfig($config);

            return ProductResource::collection($products);
        } catch (QueryException $exception) {

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
                "price" => $request->price,
                "category_id" => $request->category_id,
                "sale" => $request->sale,
                'content' => $request->content,
                'sale' => $request->sale,
                'status' => $request->status,
                'quantity' => $request->quantity,
                'time_sale' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->time_sale)->format('Y-m-d H:i:s'),
                'user_id' => JWTAuth::parseToken()->authenticate()->id,
                'brand_id' => $request->brand_id,
            ];

            $images = array();
            if ($files = $request->file('images')) {
                foreach ($files as $key => $value) {
                    $fileName = $value->getClientOriginalName();
                    $fileExt = $value->getClientOriginalExtension();
                    $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . Carbon::now()->timestamp;
                    array_push($images, [
                        'id' => $key,
                        'image' => 'images/products/' . $fileName . '.' . $fileExt,
                        'title' => $fileName,
                    ]);
                    $value->move('images/products', $fileName . '.' . $fileExt);
                }
            }
            $data['images'] = json_encode($images, true);

            $productDetail = array();
            foreach ($request->infor["name"] as $key => $name) {
                $productDetail[$key] = array(
                    "name" => $name,
                    "detail" => $request->infor["detail"][$key],
                );
            }

            $product = $this->product->createProduct($data, $productDetail, $request->tags);

            DB::commit();
            // $product->with(["tags", "images"])->get();

            return response()->json([
                'message' => "create success",
                'data' => new ProductWithRelationResource($product),
            ], 200);
        } catch (QueryException $exception) {
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