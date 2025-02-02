<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Unit;
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
        $product_list_with_variant = $this->productWithVariant();
        $product_list_without_variant = $this->productWithoutVariant();

        return view('backend.rf_quotation.create', compact('customer_list', 'warehouse_list', 'product_list_with_variant', 'product_list_without_variant'));
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

    private function productWithVariant()
    {
        return Product::join('product_variants', 'products.id', 'product_variants.product_id')
            ->ActiveStandard()
            ->whereNotNull('is_variant')
            ->select('products.id', 'products.name', 'product_variants.item_code')
            ->orderBy('position')
            ->get();
    }

    private function productWithoutVariant()
    {
        return Product::ActiveStandard()->select('id', 'name', 'code')
            ->whereNull('is_variant')->get();
    }
}
