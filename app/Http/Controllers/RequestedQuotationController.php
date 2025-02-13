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
use App\Models\RequestedQuotationDetail;

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
            'type' => 'required|in:regular_mro,project,techtesla_stock',
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
                $path = $request->file('document')->store('rf-quotation/document', 'public');
                $rf_quotation->update(['document' => $path]);
            }

            $rf_quotation->items()->createMany(array_map(function (
                $product_id,
                $product_code,
                $quantity,
                $proposed_price
            ) {
                return [
                    'product_id' => $product_id,
                    'product_code' => $product_code,
                    'quantity' => $quantity,
                    'proposed_price' => $proposed_price,
                ];
            }, $data['product_id'], $data['product_code'], $data['quantity'], $data['proposed_price']));
        });

        return redirect()->route('rf-quotation.index')->with('message', 'Requested quotation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestedQuotation $rf_quotation)
    {
        $item = $rf_quotation->load('items.product', 'customer');
        return view('backend.rf_quotation.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestedQuotation $rf_quotation)
    {
        $item = $rf_quotation->load('items.product', 'customer');
        $warehouse_list = Warehouse::where('is_active', true)->get();
        $customer_list = Customer::where('is_active', true)->get();
        $product_list_with_variant = $this->productWithVariant();
        $product_list_without_variant = $this->productWithoutVariant();
        return view('backend.rf_quotation.edit', compact('item', 'customer_list', 'warehouse_list', 'product_list_with_variant', 'product_list_without_variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestedQuotation $rf_quotation)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|integer',
            'date' => 'required|date',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,csv,docx,xlsx|max:10240',
            'type' => 'required|in:regular_mro,project,techtesla_stock',
            'product_id' => 'required|array',
            'id' => 'nullable|array',
            'product_code' => 'required|array',
            'quantity' => 'required|array',
            'proposed_price' => 'required|array',
            'note' => 'nullable|string',
            'delivery_info' => 'nullable|string',
            'id.*' => 'nullable|integer',
            'product_id.*' => 'required|integer',
            'product_code.*' => 'required|string',
            'quantity.*' => 'required|integer',
            'proposed_price.*' => 'required|numeric',
        ]);

        DB::transaction(function () use ($data, $request, $rf_quotation) {
            $rf_quotation->update([
                'customer_id' => $data['customer_id'],
                'date' => $data['date'],
                'type' => $data['type'],
                'note' => $data['note'],
                'delivery_info' => $data['delivery_info'],
            ]);

            if ($request->hasFile('document')) {
                // remove old file
                if ($rf_quotation->document) {
                    unlink(storage_path('app/public/' . $rf_quotation->document));
                }
                $path = $request->file('document')->store('rf-quotation/document', 'public');
                $rf_quotation->update(['document' => $path]);
            }

            $existing_item_id = [];

            $existing_item_id = $data['id'] ?? [];

            // Prevent accidental deletion of all items
            if (!empty($existing_item_id)) {
                $rf_quotation->items()->whereNotIn('id', $existing_item_id)->delete();
            }

            // update or create new items
            foreach ($data['product_id'] as $key => $value) {
                $id = isset($data['id'][$key]) ? $data['id'][$key] : null;
                $item = $rf_quotation->items()->updateOrCreate(
                    ['id' => $data['id'][$key]],
                    [
                        'product_id' => $value,
                        'product_code' => $data['product_code'][$key],
                        'quantity' => $data['quantity'][$key],
                        'proposed_price' => $data['proposed_price'][$key],
                    ]
                );
                if ($id) {
                    $existing_item_id[] = $item->id;
                }
            }
        });

        return redirect()->route('rf-quotation.index')->with('message', 'Requested quotation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestedQuotation $rf_quotation)
    {
        DB::transaction(function () use ($rf_quotation) {
            if ($rf_quotation->document) {
                unlink(storage_path('app/public/' . $rf_quotation->document));
            }
            $rf_quotation->items()->delete();
            $rf_quotation->delete();
        });
        return redirect()->route('rf-quotation.index')->with('message', 'Requested quotation deleted successfully.');
    }

    /**
     * Get dashboard data
     */
    public function dashboard()
    {
        return view('backend.rf_quotation.dashboard');
    }

    /**
     * Get report data
     */
    public function report(Request $request)
    {
        return view('backend.rf_quotation.report');
    }

    /**
     * Get rfq product list by supplier wise
     */
    public function supplierWise(Request $request)
    {
        $rfQs = RequestedQuotation::with('priceCollection.product', 'priceCollection.supplier')
            ->whereHas('priceCollection', function ($query) {
                $query->where('is_selected', true);
            })->get();

        // dd($rfQs);

        return view('backend.rf_quotation.supplier-wise', compact('rfQs'));
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
