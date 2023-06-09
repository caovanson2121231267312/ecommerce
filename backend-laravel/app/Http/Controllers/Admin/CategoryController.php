<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\DataController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    use DataController;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->middleware('auth:api');
        $this->category = $categoryRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $categories = $this->category->getCategories($this->data);

            return CategoryResource::collection($categories);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 500);
        }
    }

    public function store(CategoryRequest $request)
    {
        $data = [
            "name" => $request->name,
            "parent_id" => $request->parent_id,
            "description" => $request->description,
        ];

        $category = $this->category->create($data);

        return response()->json([
            'message' => "create success",
            'data' => new CategoryResource($category),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->category->findWithRelation($id, ["brands", "products"]);

            return response()->json([
                'data' => new CategoryResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_model_not_found'),
            ], 500);
        }
    }


    public function update(CategoryRequest $request, $id)
    {
        try {
            $data = [
                "name" => $request->name,
                "parent_id" => $request->parent_id,
                "description" => $request->description,
            ];

            $category = $this->category->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new CategoryResource($category),
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

            $this->category->delete($id);

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
