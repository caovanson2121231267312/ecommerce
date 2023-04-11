<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\DataController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\UserRequest;
use App\Repositories\User\UserRepository;
use App\Http\Resources\Admin\UserResource;
use Spatie\Permission\Contracts\Permission;
use App\Http\Resources\Admin\PermissionResource;
use App\Repositories\Permission\PermissionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    use DataController;

    public function __construct(
        UserRepository $userRepo,
        PermissionRepository $permissionRepo,
    ) {
        $this->middleware('auth:api');
        $this->user = $userRepo;
        $this->permission = $permissionRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $users = $this->user->getUsers($this->data);

            return UserResource::collection($users);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
        try {
            $permissions = $this->permission->getAll();

            return PermissionResource::collection($permissions);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 500);
        }
    }

    public function store(UserRequest $request)
    {
        $user = $this->user->create([
            "name" => $request->name
        ]);
        if ($request->input('permissions')) {
            $user->syncPermissions($request->input('permissions'));
        }

        return response()->json([
            'message' => "create success",
            'data' => new UserResource($user),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->user->findWithRelationData($id, ["users", "permissions"], ["permissions"]);

            return response()->json([
                'data' => new UserResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_model_not_found'),
            ], 500);
        }
    }


    public function update(UserRequest $request, $id)
    {
        try {
            $data = [
                "name" => $request->name,
            ];

            $user = $this->user->update($id, $data);
            if ($request->input('permissions')) {
                $user->syncPermissions($request->input('permissions'));
            }

            return response()->json([
                'message' => __('update_success'),
                'data' => new UserResource($user),
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

            $this->user->delete($id);

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
