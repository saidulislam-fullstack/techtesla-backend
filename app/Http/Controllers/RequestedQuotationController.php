<?php

namespace App\Http\Controllers;

use App\DataTables\RequestedQuotationDataTable;
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
        $this->middleware('permission:rf-quotes-edit')->only('edit', 'update');
        $this->middleware('permission:rf-quotes-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(RequestedQuotationDataTable $dataTable)
    {
        return $dataTable->render('backend.rf_quotation.index');
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
        $data = $request->validate([
            'customer_id' => 'nullable|integer',
            'date' => 'required|date',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,csv,docx,xlsx|max:10240',
            'type' => 'required|in:1,2,3',
            'product_id' => 'required|array',
            'product_code' => 'required|array',
            'quantity' => 'required|array',
            'proposed_price' => 'required|array',
            'note' => 'nullable|string',
            'delivery_info' => 'nullable|string',
            'product_id.*' => 'required|integer',
            'product_code.*' => 'required|string',
            'quantity.*' => 'required|integer',
            'proposed_price.*' => 'required|numeric',
        ]);

        DB::transaction(function () use ($data, $request) {
            $rf_quotation = RequestedQuotation::create([
                'customer_id' => $data['customer_id'],
                'date' => $data['date'],
                'type' => $data['type'],
                'note' => $data['note'],
                'delivery_info' => $data['delivery_info'],
            ]);

            if ($request->hasFile('document')) {
                $rf_quotation->store('rf-quotation/document', $request->file('document'));
            }

            $rf_quotation->items()->createMany(array_map(function (
                $product_id,
                $quantity,
                $proposed_price
            ) {
                return [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'proposed_price' => $proposed_price,
                ];
            }, $data['product_id'], $data['quantity'], $data['proposed_price']));
        });

        return redirect()->route('rf-quotation.index')->with('message', 'Requested quotation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestedQuotation $rf_quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestedQuotation $rf_quotation)
    {
        return view('backend.rf_quotation.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestedQuotation $rf_quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestedQuotation $rf_quotation)
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
