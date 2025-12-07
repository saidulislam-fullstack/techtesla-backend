@extends('backend.layout.main')

@push('styles')

@endpush

@section('content')
<x-invoice-print title="Purchase #{{ $purchase->reference_no }}" filename="RFQ_{{ $purchase->reference_no }}">
    <!-- RFQ Details -->
    <div style="border: 1px solid #000; padding: 5px; margin-top: 5px; display: flex; color: #000; border-radius: 5px;">
        <div style="width: 50%;">
            <p style="margin-bottom: 5px;">
                <strong>Purchase Date:</strong> {{ \Carbon\Carbon::parse($purchase->created_at)->format('m/d/Y') }} <br>
                <strong>Reference / Voucher No:</strong> {{ $purchase->reference_no }} <br>
                <strong>Warehouse: </strong> {{ $purchase->warehouse?->name }} <br>
                <strong>Note:</strong> {{ $purchase->note ?? 'N/A' }} <br>
            </p>
        </div>
        <div style="width: 50%;">
            <p style="margin-bottom: 5px;">
                <strong>Status:</strong> {{ $purchase->status == 1 ? 'Received' : ($purchase->status == 2
                ? 'Partial' : ($purchase->status == 4
                ? 'Ordered' : 'Pending')) }} </br>
                <strong>Supplier:</strong> {{ $purchase->supplier?->name ?? 'N/A' }}</br>
                <strong>Payment Status:</strong> {{ $purchase->payment_status == 1 ? 'Due' : 'Paid' }}</br>
                <strong>RFQ Order:</strong> {{ $purchase->rfq_id ? 'Yes' : 'No' }}</br>
            </p>
        </div>
    </div>

    <!-- Item Table -->
    <h6 style="margin-top: 1rem; color: #000;"><strong>Item</strong></h6>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; color: #000;">
        <thead>
            <tr style="background-color: #d3d3d3;">
                <th style="border: 1px solid #000; padding: 10px 5px;">SL</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.name')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Model')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Quantity')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Net Unit Cost')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Discount')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Tax')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Subtotal')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lims_product_purchase_data as $index => $product_purchase)
            <?php
                $product_data = DB::table('products')->find($product_purchase->product_id);
                if($product_purchase->variant_id) {
                    $product_variant_data = \App\Models\ProductVariant::FindExactProduct($product_data->id, $product_purchase->variant_id)->select('item_code')->first();
                    if($product_variant_data)
                        $product_data->code = $product_variant_data->item_code;
                }

                $tax = DB::table('taxes')->where('rate', $product_purchase->tax_rate)->first();

                $units = DB::table('units')->where('base_unit', $product_data->unit_id)->orWhere('id', $product_data->unit_id)->get();

                $unit_name = array();
                $unit_operator = array();
                $unit_operation_value = array();

                foreach($units as $unit) {
                    if($product_purchase->purchase_unit_id == $unit->id) {
                        array_unshift($unit_name, $unit->unit_name);
                        array_unshift($unit_operator, $unit->operator);
                        array_unshift($unit_operation_value, $unit->operation_value);
                    }
                    else {
                        $unit_name[]  = $unit->unit_name;
                        $unit_operator[] = $unit->operator;
                        $unit_operation_value[] = $unit->operation_value;
                    }
                }
                if($product_data->tax_method == 1){
                    $product_cost = ($product_purchase->net_unit_cost + ($product_purchase->discount / $product_purchase->qty)) / $unit_operation_value[0];
                }
                else{
                    $product_cost = (($product_purchase->total + ($product_purchase->discount / $product_purchase->qty)) / $product_purchase->qty) / $unit_operation_value[0];
                }


                $temp_unit_name = $unit_name = implode(",",$unit_name) . ',';

                $temp_unit_operator = $unit_operator = implode(",",$unit_operator) .',';

                $temp_unit_operation_value = $unit_operation_value =  implode(",",$unit_operation_value) . ',';

                $product_batch_data = \App\Models\ProductBatch::select('batch_no', 'expired_date')->find($product_purchase->product_batch_id);
            ?>
            <tr>
                <td style="border: 1px solid #000; padding: 5px;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{$product_data->name}}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{$product_data->code}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{$product_purchase->qty}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_purchase->net_unit_cost, $general_setting->decimal, '.', '')}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_purchase->discount, $general_setting->decimal, '.', '')}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_purchase->tax, $general_setting->decimal, '.', '')}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_purchase->total, $general_setting->decimal, '.', '')}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border: 1px solid #000; padding: 5px;">Total Item Cost:
                </td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    {{$purchase->total_qty}}
                </td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;"></td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    {{ number_format((float)$purchase->total_discount, $general_setting->decimal, '.',
                    '')}}
                </td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    {{ number_format((float)$purchase->total_tax, $general_setting->decimal, '.',
                    '')}}
                </td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    {{ number_format((float)$purchase->total_cost, $general_setting->decimal, '.',
                    '')}}
                </td>
            </tr>
            <tr>
                <td colspan="7" class="text-right pr-2">Total Discount</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    {{ number_format((float)$purchase->total_discount, $general_setting->decimal, '.', '')}}</td>
            </tr>

            <tr>
                <td colspan="7" class="text-right pr-2">Shipping Cost</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    {{ number_format((float)$purchase->shipping_cost, $general_setting->decimal, '.', '')}}</td>
            </tr>
            <tr>
                <td colspan="7" class="text-right pr-2"><strong>Grand Total</strong></td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    <strong>{{ number_format((float)$purchase->grand_total, $general_setting->decimal, '.',
                        '')}}</strong>
                </td>
            </tr>
        </tbody>
    </table>
</x-invoice-print>
@endsection

@push('scripts')

@endpush