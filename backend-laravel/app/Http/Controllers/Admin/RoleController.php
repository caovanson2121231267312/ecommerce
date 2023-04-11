<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\DataController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Resources\Admin\PermissionResource;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\RoleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    use DataController;

    public function __construct(
        RoleRepository $roleRepo,
        PermissionRepository $permissionRepo
    ) {
        $this->middleware('auth:api');
        $this->role = $roleRepo;
        $this->permission = $permissionRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $Roles = $this->role->getRoles($this->data);

            return RoleResource::collection($Roles);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }

    public function create()
    {
        $data = $this->permission->getAll();
        return response()->json([
            'data' => PermissionResource::collection($data),
        ], 200);
    }

    public function store(RoleRequest $request)
    {
        $role = $this->role->create([
            "name" => $request->name,
        ]);

        if ($request->input('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return response()->json([
            'message' => "create success",
            'data' => new RoleResource($role),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->role->findWithRelationData($id, ["permissions", "users"], ["permissions"]);

            return response()->json([
                'data' => new RoleResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_model_not_found'),
            ], 500);
        }
    }


    public function update(RoleRequest $request, $id)
    {
        try {
            $data = [
                "name" => $request->name,
            ];

            $role = $this->role->update($id, $data);
            if ($request->input('permissions')) {
                $role->syncPermissions($request->input('permissions'));
            }

            return response()->json([
                'message' => __('update_success'),
                'data' => new RoleResource($role),
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

            $this->role->delete($id);

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