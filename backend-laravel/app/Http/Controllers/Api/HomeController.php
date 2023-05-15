<?php

namespace App\Http\Controllers\Api;

use App\Events\ChatEvents;
use Exception;
use Carbon\Carbon;
use App\Models\Rate;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Jobs\SendEmailReport;
use Illuminate\Support\Facades\DB;
use App\Exports\MonthlyReportExport;
use App\Http\Controllers\Controller;
use App\Jobs\MonthlyReportExportJob;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Product\ProductRepository;
use App\Mail\SendEmailReport as MailSendEmailReport;
use App\Models\User;

class HomeController extends Controller
{
    public $product;

    public function __construct(ProductRepository $productRepo)
    {
        $this->product = $productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->product->getProduct($request);
        return response()->json(
            $products
        );
    }

    public function export()
    {
        // return Excel::download(new MonthlyReportExport, 'order.xlsx');
        $export = new MonthlyReportExportJob;
        dispatch($export);
    }

    public function email()
    {
        $email = (new SendEmailReport("hello"));
        dispatch($email);
    }

    public function chat()
    {
        $user = User::first();
        event(new ChatEvents("hello abc cao van sơn", $user));
    }

    public function product($slug)
    {
        try {
            $products = Product::findBySlugOrFail($slug)
                // ->select('*', DB::raw('(SELECT AVG(rate) FROM rates WHERE rates.product_id = products.id) as avg_rate'))
                // ->loadCount(['rates'])
                ->load(['category', 'tags', 'details']);

            return response()->json(
                $products
            );
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
                "code" => 500
            ], 500);
        }
    }

    public function rateOfProduct($id)
    {
        $rates = Rate::where('product_id', "=", $id)->with('user')->latest()->get();

        $detail = Rate::select(DB::raw('count(*) as count'), DB::raw('avg(rate) as average'))
            ->where('product_id', "=", $id)->first();

        return response()->json([
            "detail" => $detail,
            "rates" => $rates,
        ]);
    }

    public function hotSale()
    {
        $products = $this->product->getProductWithHotSale();
        return response()->json(
            $products
        );
    }

    public function categories()
    {
        $data = Category::with(['brands'])->take(10)->get();

        return response()->json($data);
    }

    public function cart(Request $request)
    {
        $arr = array();
        foreach ($request->cart as $value) {
            array_push($arr, $value['id']);
        }
        try {
            $products = Product::whereIn("id", $arr)->with(['category'])->get();

            return response()->json([
                "data" => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
                "code" => 500
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
