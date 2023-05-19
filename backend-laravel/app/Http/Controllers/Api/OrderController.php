<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Admin\OrderResource;
use App\Repositories\Order\OrderRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    public function __construct(OrderRepository $orderRepo)
    {
        $this->order = $orderRepo;
    }

    public function index(Request $request, $ref)
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

    public function update(Request $request, $ref)
    {
        try {
            $data = [
                "status_payment" => $request->status_payment,
            ];

            $order = $this->order->updatePaymentByRef($ref, $data);

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

    public function search_order(Request $request)
    {
        try {
            $phone = $request->phone;
            $email = $request->email;

            $orders = $this->order->findOrders($phone, $email);

            return OrderResource::collection($orders);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 500);
        }
    }
}
