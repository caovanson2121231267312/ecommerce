<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\CategoryResource;
use App\Repositories\Category\CategoryRepository;
use App\Models\Category;
use Illuminate\Database\QueryException;
use App\Http\Requests\admin\CategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use DB;

class CategoryController extends Controller
{
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->category = $categoryRepo;
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
            $categories = $this->category->category($config);

            return CategoryResource::collection($categories);

        } catch (QueryException $exception){

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

        if ($file = $request->file('image')){
            $fileName = $file->getClientOriginalName();
            $fileExt = $file->getClientOriginalExtension();
            $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . Carbon::now()->timestamp . '.' . $fileExt;
            $data['image'] = $fileName;
            $file->move('images/categories' , $fileName);
        }

        $category = $this->category->create($data);

        return response()->json([
            'message' => "create success",
            'data' => new CategoryResource($category),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->category->find($id);

            return response()->json([
                'data' => new CategoryResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_mdoel_not_found'),
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

            if ($file = $request->file('image')){
                $fileName = $file->getClientOriginalName();
                $fileExt = $file->getClientOriginalExtension();
                $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . Carbon::now()->timestamp . '.' . $fileExt;
                $data['image'] = $fileName;
                $file->move('images/categories' , $fileName);
            }

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