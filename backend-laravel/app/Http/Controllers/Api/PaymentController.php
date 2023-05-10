<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Exception;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function create_payment(Request $request)
    {
        try {


            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $vnp_TxnRef = date('YmdHis') . rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
            $vnp_Amount = $request->amount; // Số tiền thanh toán
            $vnp_Locale = $request->language; //Ngôn ngữ chuyển hướng thanh toán
            $vnp_BankCode = $request->bankCode; //Mã phương thức thanh toán
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

            $startTime = date("YmdHis");
            $expire = date('YmdHis', strtotime('+45 minutes', strtotime($startTime)));

            $dataOrder = array(
                "name" => $request->firstname . ' ' . $request->lastname,
                "email" => $request->email,
                "phone" => $request->phone,
                "address" => $request->address,
                "note" => $request->note,
                "status" => 0,
                "quantity" => $request->quantity,
                "price" => $request->price,
                "sale_price" => $request->amount,
                "ip_address" => $vnp_IpAddr,
                "ref" => $vnp_TxnRef,
            );

            $products = $request->products;

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => env('vnp_TmnCode'),
                "vnp_Amount" => $vnp_Amount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toán GD:" . $vnp_TxnRef,
                "vnp_OrderType" => "order",
                "vnp_ReturnUrl" => env('vnp_Returnurl'),
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => $expire
            );

            $payload = array_merge($dataOrder, $inputData, array("products" => $products));

            $dataOrder['payload'] = json_encode($payload);

            $order = Order::create($dataOrder);
            foreach (json_decode($products) as $value) {
                OrderDetail::create([
                    "quantity" => $value->count,
                    "price" => $value->price,
                    "sale" => $value->sale,
                    "product_id" => $value->id,
                    "order_id" => $order->id,
                ]);
            }

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = env('vnp_Url') . "?" . $query;

            $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('vnp_HashSecret')); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            return response()->json([
                "url" => $vnp_Url
            ], 200);
        } catch (Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/order.log'),
            ])->warning($e);

            return response()->json([
                "url" => $vnp_Url,
                "message" => __("error_order"),
            ], 500);
        }
    }

    public function vnpay(Request $request)
    {
        return view('return');
    }
}
