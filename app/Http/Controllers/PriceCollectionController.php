<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PriceCollection;
use App\Helpers\PermissionHelper;
use App\Models\RequestedQuotation;

class PriceCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:price-collection-add')->only(['create', 'store']);
        $this->middleware(function ($request, $next) {
            return PermissionHelper::checkControllerPermission([
                'index'   => 'price-collection-index',
                'show'    => 'price-collection-index',
                'create'  => 'price-collection-add',
                'store'   => 'price-collection-add',
                'edit'    => 'price-collection-edit',
                'update'  => 'price-collection-edit',
                'destroy' => 'price-collection-delete',
            ], $request, $next);
        });
    }

    public function create(Request $request)
    {
        $rfqs = RequestedQuotation::with('items.product')
            ->where('status', 'pending')
            ->get();
        $suppliers = Supplier::where('is_active', true)->get();
        $currencies = Currency::where('is_active', true)->get();
        $rfq_items = null;
        if ($request->rfq_id) {
            $rfq_items = RequestedQuotation::with('items.product')
                ->find('id', $request->rfq_id);
        }
        return view('backend.price_collection.create', compact('rfqs', 'suppliers', 'rfq_items', 'currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfq_id' => 'required|array',
            'product_id' => 'required|array',
            'rfq_item_id' => 'required|array',
            'supplier_id' => 'required|array',
            'market_price' => 'required|array',
            'note' => 'nullable|array',
            'product_id.*' => 'required|exists:products,id',
            'rfq_id.*' => 'required|exists:requested_quotations,id',
            'rfq_item_id.*' => 'required|exists:requested_quotation_details,id',
            'supplier_id.*' => 'required|exists:suppliers,id',
            'market_price.*' => 'required|numeric',
            'note.*' => 'nullable|string',
            'currency_id.*' => 'nullable|exists:currencies,id',
            'currency_rate.*' => 'nullable|numeric',
            'shipping_weight.*' => 'nullable|numeric',
            'customs_unit_cost.*' => 'nullable|numeric',
            'customs_total_cost.*' => 'nullable|numeric',
            'profit_margin_percentage.*' => 'nullable|numeric',
            'profit_margin_amount.*' => 'nullable|numeric',
            'tax_amount.*' => 'nullable|numeric',
            'vat_amount.*' => 'nullable|numeric',
            'other_cost.*' => 'nullable|numeric',
            'total_cost.*' => 'nullable|numeric',
            'origin.*' => 'nullable|string',
            'delivery_days.*' => 'nullable|numeric',
        ]);

        foreach ($request->rfq_id as $key => $rfq_id) {
            $currencyConvertedPrice = $request->market_price[$key] * $request->currency_rate[$key];
            $profitAmount = ($currencyConvertedPrice * $request->profit_margin_percentage[$key]) / 100;
            $othersCost = $request->customs_total_cost[$key] + $profitAmount + $request->tax_amount[$key] + $request->vat_amount[$key];
            $totalCost = $currencyConvertedPrice + $othersCost;
            PriceCollection::create([
                'rfq_id' => $rfq_id,
                'rfq_item_id' => $request->rfq_item_id[$key],
                'product_id' => $request->product_id[$key],
                'supplier_id' => $request->supplier_id[$key],
                'price' => $request->market_price[$key],
                'note' => $request->note[$key],
                'currency_id' => $request->currency_id[$key],
                'currency_rate' => $request->currency_rate[$key],
                'shipping_weight' => $request->shipping_weight[$key],
                'customs_unit_cost' => $request->customs_unit_cost[$key],
                'customs_total_cost' => $request->customs_total_cost[$key],
                'profit_margin_percentage' => $request->profit_margin_percentage[$key],
                'profit_margin_amount' => $profitAmount,
                'tax_amount' => $request->tax_amount[$key],
                'vat_amount' => $request->vat_amount[$key],
                'other_cost' => $othersCost,
                'total_cost' => $totalCost,
                'origin' => $request->origin[$key],
                'delivery_days' => $request->delivery_days[$key],
            ]);
        }

        return redirect()->route('price-collection.create')
            ->with('message', 'Price Collection created successfully.');
    }

    public function selection($rfqId)
    {
        $rfq = RequestedQuotation::find($rfqId);
        $items = PriceCollection::with([
            'rfqItem',
            'product',
            'supplier'
        ])
            ->where('rfq_id', $rfqId)
            ->get()
            ->groupBy('product_id');

        $rfqList = RequestedQuotation::where('status', 'pending')->get();
        return view('backend.price_collection.selection', compact('items', 'rfq', 'rfqList'));
    }

    public function selectionStore(Request $request, RequestedQuotation $rfq)
    {
        $data = $request->validate([
            'item_id' => 'required|array',
            'item_id.*' => 'required|exists:price_collections,id',
        ]);

        // Group the selected items by product_id
        $grouped_items = collect($data['item_id'])->map(function ($item_id) use ($rfq) {
            return PriceCollection::where('rfq_id', $rfq->id)->find($item_id);
        })->groupBy('product_id');

        // Loop through each product group and update the selected item
        foreach ($grouped_items as $product_id => $items) {
            PriceCollection::where('product_id', $product_id)
                ->where('rfq_id', $rfq->id)
                ->whereNotIn('id', $items->pluck('id')->toArray())
                ->update(['is_selected' => 0]);

            // Now, select the new item(s)
            foreach ($items as $selected_item) {
                $selected_item->is_selected = 1;
                $selected_item->save();
            }
        }

        return redirect()->route('rf-quotation.index')
            ->with('message', 'Price Collection created successfully.');
    }

    public function getRfqItems(Request $request)
    {
        $rfq_items = RequestedQuotation::with('items.product')
            ->find($request->rfq_id);
        return response()->json($rfq_items);
    }
}
