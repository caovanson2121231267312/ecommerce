<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\DataController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Resources\Admin\PermissionResource;
use App\Repositories\Permission\PermissionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionController extends Controller
{
    use DataController;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->middleware('auth:api');
        $this->permission = $permissionRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $permissions = $this->permission->getPermissions($this->data);

            return PermissionResource::collection($permissions);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }

    public function store(PermissionRequest $request)
    {
        $data = [
            "name" => $request->name,
        ];

        $permission = $this->permission->create($data);

        return response()->json([
            'message' => "create success",
            'data' => new PermissionResource($permission),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->permission->findWithRelation($id, ["roles", "users"]);

            return response()->json([
                'data' => new PermissionResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_model_not_found'),
            ], 500);
        }
    }


    public function update(PermissionRequest $request, $id)
    {
        try {
            $data = [
                "name" => $request->name,
            ];

            $permission = $this->permission->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new PermissionResource($permission),
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

            $this->permission->delete($id);

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