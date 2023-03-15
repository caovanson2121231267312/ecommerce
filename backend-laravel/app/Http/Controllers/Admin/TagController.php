<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\TagResource;
use App\Repositories\Tag\TagRepository;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\TagRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use DB;

class TagController extends Controller
{
    public function __construct(TagRepository $tagRepo)
    {
        $this->tag = $tagRepo;
    }

    public function index(Request $request)
    {
        $data = [
            "page" => $request->page ?? null,
            "page_size" => $request->page_size ?? null,
            "order_by" => $request->order_by ?? "id",
            "mode" => $request->mode ?? "ASC",
            "search" => $request->search ?? null,
            "key" => $request->key ?? null,
        ];
        try {
            $tags = $this->tag->getWithConfig($data);

            return TagResource::collection($tags);
        } catch (QueryException $exception){

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }

    public function store(TagRequest $request)
    {
        $data = [
                "name" => $request->name,
            ];

        $tag = $this->tag->create($data);

        return response()->json([
            'message' => "create success",
            'data' => new TagResource($tag),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->tag->find($id);

            return response()->json([
                'data' => new TagResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_mdoel_not_found'),
            ], 500);
        }
    }


    public function update(TagRequest $request, $id)
    {
        try {
            $data = [
                "name" => $request->name,
            ];

            $tag = $this->tag->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new TagResource($tag),
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

            $this->tag->delete($id);

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
