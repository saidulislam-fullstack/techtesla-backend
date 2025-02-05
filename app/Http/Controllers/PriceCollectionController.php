<?php

namespace App\Http\Controllers;

use App\Models\PriceCollection;
use App\Models\RequestedQuotation;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PriceCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:price-collection-add')->only(['create', 'store']);
    }

    public function create(Request $request)
    {
        $rfqs = RequestedQuotation::with('items.product')
            ->where('status', 'pending')
            ->get();
        $suppliers = Supplier::where('is_active', true)->get();
        $rfq_items = null;
        if ($request->rfq_id) {
            $rfq_items = RequestedQuotation::with('items.product')
                ->find('id', $request->rfq_id);
        }
        return view('backend.price_collection.create', compact('rfqs', 'suppliers', 'rfq_items'));
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
            'note.*' => 'nullable|array',
        ]);

        foreach ($request->rfq_id as $key => $rfq_id) {
            PriceCollection::create([
                'rfq_id' => $rfq_id,
                'rfq_item_id' => $request->rfq_item_id[$key],
                'product_id' => $request->product_id[$key],
                'supplier_id' => $request->supplier_id[$key],
                'price' => $request->market_price[$key],
                'note' => $request->note[$key],
            ]);
        }

        return redirect()->route('price-collection.create')
            ->with('message', 'Price Collection created successfully.');
    }

    public function selection(RequestedQuotation $rfq)
    {
        $items = PriceCollection::with([
            'rfqItem',
            'product',
            'supplier'
        ])
            ->where('rfq_id', $rfq->id)
            ->orderBy('is_selected')
            ->orderBy('supplier_id')
            ->orderBy('product_id')
            ->get();

        return view('backend.price_collection.selection', compact('items', 'rfq'));
    }

    public function selectionStore(Request $request, RequestedQuotation $rfq)
    {
        $data = $request->validate([
            'item_id' => 'required|array',
            'item_id.*' => 'required|exists:price_collections,id',
        ]);

        foreach ($data['item_id'] as $item_id) {
            $item = PriceCollection::find($item_id);
            $item->is_selected = 1;
            $item->save();
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
