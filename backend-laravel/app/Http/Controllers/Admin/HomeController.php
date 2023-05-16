<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // $orders = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
        //     ->orderBy('created_at')
        //     ->get();

        $orderByWeek = Order::selectRaw('DAYOFWEEK(created_at) as dayOfWeek, COUNT(*) as orderCount')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('dayOfWeek')
            ->orderBy('dayOfWeek')
            ->get();

        $users = User::count();

        $products = Product::count();

        $orders = Order::count();

        $revenue = Order::sum('sale_price');

        return  response()->json([
            "orderByWeek" => $orderByWeek,
            "users" => $users,
            "products" => $products,
            "orders" => $orders,
            "revenue" => $revenue,
        ], 200);
    }
}
