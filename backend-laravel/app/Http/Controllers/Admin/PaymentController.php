<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\PaymentRequest;
use App\Http\Resources\Admin\PaymentResource;
use App\Repositories\Payment\PaymentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{
    public function __construct(PaymentRepository $paymentRepo)
    {
        $this->middleware('auth:api');
        $this->payment = $paymentRepo;
    }

    public function index(Request $request)
    {
        $this->setData($request);

        try {
            $Payments = $this->payment->getPayments($this->data);

            return PaymentResource::collection($Payments);
        } catch (QueryException $exception) {

            return response()->json([
                "mess" => $exception->getMessage(),
            ], 400);
        }
    }

    public function store(PaymentRequest $request)
    {
        $data = [
            "card_name" => $request->card_name,
            "card_number" => $request->card_number,
            "user_name" => $request->user_name,
            "phone_number" => $request->phone_number,
            "hash" => $request->hash,
            "type" => 1,
        ];

        if ($request->has("qr")) {
            $file = $request->file('qr');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/qr/';
            $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . Carbon::now()->timestamp;
            $fileExt = $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName . "." . $fileExt);
            $data['qr'] = $fileName . "." . $fileExt;
        }

        $Payment = $this->payment->create($data);

        return response()->json([
            'message' => "create success",
            'data' => new PaymentResource($Payment),
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->payment->findWithRelation($id, []);

            return response()->json([
                'data' => new PaymentResource($data),
            ], 200);
        } catch (ModelNotFoundException $exception) {

            return response()->json([
                'message' => __('have_error_model_not_found'),
            ], 500);
        }
    }


    public function update(PaymentRequest $request, $id)
    {
        try {
            $data = [
                "card_name" => $request->card_name,
                "card_number" => $request->card_number,
                "user_name" => $request->user_name,
                "phone_number" => $request->phone_number,
                "card_name" => $request->name,
            ];

            if ($request->has("qr")) {
                $file = $request->file('qr');
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path() . '/images/qr/';
                $fileName = Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '-' . Carbon::now()->timestamp;
                $fileExt = $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName . "." . $fileExt);
                $data['qr'] = $fileName . "." . $fileExt;
            }

            $Payment = $this->payment->update($id, $data);

            return response()->json([
                'message' => __('update_success'),
                'data' => new PaymentResource($Payment),
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

            $this->payment->delete($id);

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
