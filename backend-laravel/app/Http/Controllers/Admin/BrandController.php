<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\BrandRequest;
use App\Http\Resources\Admin\BrandResource;
use App\Repositories\Brand\BrandRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BrandController extends Controller
{
    public function __construct(BrandRepository $brandRepo)
    {
        $this->middleware('auth:api');
        $this->brand = $brandRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $brands = $this->brand->getBrands($this->data);

            return BrandResource::collection($brands);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }

    public function store(BrandRequest $request)
    {
        $data = [
            "name" => $request->name,
        ];

        $brand = $this->brand->create($data);

        return response()->json([
            'message' => "create success",
            'data' => new BrandResource($brand),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->brand->findWithRelation($id, ["products", "categories"]);

            return response()->json([
                'data' => new BrandResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_model_not_found'),
            ], 500);
        }
    }


    public function update(BrandRequest $request, $id)
    {
        try {
            $data = [
                "name" => $request->name,
            ];

            $brand = $this->brand->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new BrandResource($brand),
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

            $this->brand->delete($id);

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
