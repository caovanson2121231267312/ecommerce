<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Admin\OrderResource;
use App\Repositories\Order\OrderRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    public function __construct(OrderRepository $orderRepo)
    {
        $this->middleware('auth:api');
        $this->order = $orderRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $orders = $this->order->getOrders($this->data);
            // dd($orders);
            return OrderResource::collection($orders);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->order->findWithRelation($id, ["brands", "products"]);

            return response()->json([
                'data' => new OrderResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_model_not_found'),
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $data = [
                "status" => $request->status,
            ];

            $order = $this->order->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new OrderResource($order),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have error :' . $exception->getMessage()),
            ], 500);
        }
    }

    public function status(Request $request, $id)
    {
        try {
            $data = [
                "status" => $request->status,
            ];

            $order = $this->order->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new OrderResource($order),
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

            $this->order->delete($id);

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
