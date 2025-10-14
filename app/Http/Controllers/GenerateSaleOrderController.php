<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\CustomField;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use App\Models\RequestedQuotation;
use App\Models\RewardPointSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Product_Sale;

class GenerateSaleOrderController extends Controller
{
    public function create()
    {
        $rfqs = RequestedQuotation::with('customer', 'items.product')->with([
            'priceCollection' => function ($query) {
                $query->where('is_selected', 1);
            },
            'priceCollection.product:id,name,code,type,cost,price,is_variant,unit_id',
            'priceCollection.product.unit:id,unit_name,unit_code,base_unit,operator,operation_value',
            'priceCollection.supplier:id,name,company_name,email,phone_number,address',
            'items.product',
            'customer'
        ])
            ->whereIn('type', ['regular_mro', 'project'])
            ->whereHas('priceCollection', function ($query) {
                return $query->where('is_selected', 1);
            })
            ->get();

        return view('backend.rf_quotation.generate-sale-order', compact('rfqs'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {

            $rfq = RequestedQuotation::find($data['rfq_id']);

            $data['user_id'] = Auth::id();
            $data['warehouse_id'] = Warehouse::first()->id;
            $data['customer_id'] = $rfq->customer_id;

            $cash_register_data = CashRegister::where([
                ['user_id', $data['user_id']],
                ['warehouse_id', $data['warehouse_id']],
                ['status', true]
            ])->first();

            if ($cash_register_data)
                $data['cash_register_id'] = $cash_register_data->id;

            if (isset($data['created_at']))
                $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
            else
                $data['created_at'] = date("Y-m-d H:i:s");

            if (!isset($data['reference_no']))
                $data['reference_no'] = 'sr-' . date("Ymd") . '-' . date("his");

            $lims_sale_data = Sale::create([
                'reference_no' => $data['reference_no'],
                'user_id' => $data['user_id'],
                'cash_register_id' => $data['cash_register_id'] ?? null,
                'table_id' => null,
                'queue' => null,
                'customer_id' => $data['customer_id'],
                'warehouse_id' => $data['warehouse_id'],
                'biller_id' => 1,
                'item' => count($data['items']['product_id']),
                'total_qty' => array_sum($data['items']['quantity']),
                'total_discount' => 0,
                'total_tax' => 0,
                'total_price' => $data['grand_total'],
                'order_tax_rate' => 0,
                'order_tax' => 0,
                'order_discount_type' => null,
                'order_discount_value' => 0,
                'order_discount' => 0,
                'coupon_id' => null,
                'coupon_discount' => 0.00,
                'shipping_cost' => 0,
                'grand_total' => $data['grand_total'],
                'currency_id' => 1,
                'exchange_rate' => 1,
                'sale_status' => 2,
                'payment_status' => 1,
                'paid_amount' => 0,
                'document' => null,
                'sale_note' => null,
                'staff_note' => null,
                'created_at' => now(),
                'requested_quotation_id' => $data['rfq_id']
            ]);

            $product_id = $data['items']['product_id'];
            $qty = $data['items']['quantity'];
            $sale_unit_id = $data['items']['unit_id'];
            $net_unit_price = $data['items']['unit_price'];
            $total = $data['grand_total'];
            $product_sale = [];

            foreach ($product_id as $i => $id) {
                $lims_product_data = Product::where('id', $id)->first();
                $product_sale['variant_id'] = null;
                $product_sale['product_batch_id'] = null;
                $product_sale['sale_id'] = $lims_sale_data->id;
                $product_sale['product_id'] = $id;
                $product_sale['imei_number'] = null;
                $product_sale['qty'] = $qty[$i];
                $product_sale['sale_unit_id'] = is_array($sale_unit_id) ? $sale_unit_id[$i] : $sale_unit_id;
                $product_sale['net_unit_price'] = $net_unit_price[$i];
                $product_sale['discount'] = 0;
                $product_sale['tax_rate'] = 0;
                $product_sale['tax'] = 0;
                $product_sale['total'] = $total[$i];
                Product_Sale::create($product_sale);
            }

            DB::commit();
            return redirect('sales')->with('message', 'Sale created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()]);
        }
        // return redirect()->back()->with('success', 'Sale Order generated successfully!');
    }
}
