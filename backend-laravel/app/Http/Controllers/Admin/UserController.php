<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\DataController;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Repositories\User\UserRepository;
use App\Http\Resources\Admin\UserResource;

class UserController extends Controller
{
    use DataController;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth:api');
        $this->user = $userRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $users = $this->user->getTags($this->data);

            return UserResource::collection($users);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }
}