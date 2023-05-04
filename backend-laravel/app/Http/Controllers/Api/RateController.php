<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Client\RateRequest;
use App\Repositories\Rate\RateRepository;

class RateController extends Controller
{
    public function __construct(
        RateRepository $rateRepo,
    ) {
        $this->middleware('auth:api');
        $this->rate = $rateRepo;
    }

    public function store(RateRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                "rate" => $request->rate,
                "content" => $request->content,
                'user_id' => JWTAuth::parseToken()->authenticate()->id,
                'product_id' => $request->product_id,
            ];
            $this->rate->create($data);

            DB::commit();

            return response()->json([
                'message' => __("create_success"),
            ], 200);
        } catch (QueryException $exception) {

            DB::rollBack();
            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }
}
