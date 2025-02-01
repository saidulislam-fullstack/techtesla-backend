<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\ProductBatch;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\RequestedQuotation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RequestedQuotationController extends Controller
{
    /**
     * RequestedQuotationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:rf-quotes-index')->only('index', 'show');
        $this->middleware('permission:rf-quotes-add')->only('create', 'store');
        // $this->middleware('permission:rf-quotes-edit')->only('edit', 'update');
        // $this->middleware('permission:rf-quotes-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.rf_quotation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouse_list = Warehouse::where('is_active', true)->get();
        $customer_list = Customer::where('is_active', true)->get();

        return view('backend.rf_quotation.create', compact('customer_list', 'warehouse_list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestedQuotation $requestedQuotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestedQuotation $requestedQuotation)
    {
        return view('backend.rf_quotation.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestedQuotation $requestedQuotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestedQuotation $requestedQuotation)
    {
        //
    }

    /**
     * Get the list of product.
     */
    public function getProduct($id)
    {
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_price = [];
        $product_data = [];
        $product_type = [];
        $product_id = [];
        $product_list = [];
        $qty_list = [];
        $batch_no = [];
        $product_batch_id = [];

        // Retrieve data of product without variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id],
            ])
            ->whereNull('product_warehouse.variant_id')
            ->whereNull('product_warehouse.product_batch_id')
            ->select('product_warehouse.*')
            ->get();

        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] =  $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
            $batch_no[] = null;
            $product_batch_id[] = null;
        }

        // Disable strict mode for database
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect();

        $lims_product_with_batch_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id],
            ])
            ->whereNull('product_warehouse.variant_id')
            ->whereNotNull('product_warehouse.product_batch_id')
            ->select('product_warehouse.*')
            ->groupBy('product_warehouse.product_id')
            ->get();

        // Re-enable strict mode
        config()->set('database.connections.mysql.strict', true);
        DB::reconnect();

        foreach ($lims_product_with_batch_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] =  $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;

            $product_batch_data = ProductBatch::select('id', 'batch_no')->find($product_warehouse->product_batch_id);
            $batch_no[] = $product_batch_data->batch_no ?? null;
            $product_batch_id[] = $product_batch_data->id ?? null;
        }

        // Retrieve data of product with variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
            ->where([
                ['products.is_active', true],
                ['product_warehouse.warehouse_id', $id],
            ])
            ->whereNotNull('product_warehouse.variant_id')
            ->select('product_warehouse.*')
            ->get();

        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $lims_product_variant_data = ProductVariant::select('item_code')
                ->FindExactProduct($product_warehouse->product_id, $product_warehouse->variant_id)
                ->first();

            $product_code[] =  $lims_product_variant_data->item_code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
            $batch_no[] = null;
            $product_batch_id[] = null;
        }

        // Retrieve product data of digital and combo
        $lims_product_data = Product::whereNotIn('type', ['standard'])->where('is_active', true)->get();
        foreach ($lims_product_data as $product) {
            $product_qty[] = $product->qty;
            $product_code[] =  $product->code;
            $product_name[] = $product->name;
            $product_type[] = $product->type;
            $product_id[] = $product->id;
            $product_list[] = $product->product_list;
            $qty_list[] = $product->qty_list;
        }

        $product_data = [
            $product_code,
            $product_name,
            $product_qty,
            $product_type,
            $product_id,
            $product_list,
            $qty_list,
            $product_price,
            $batch_no,
            $product_batch_id
        ];

        return $product_data;
    }
}
