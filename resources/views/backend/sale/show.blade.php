@extends('backend.layout.main')

@push('styles')

@endpush

@section('content')
<x-invoice-print title="Purchase #{{ $sale->reference_no }}" filename="RFQ_{{ $sale->reference_no }}">
    <!-- Sale Details -->
    <div style="border: 1px solid #000; padding: 5px; margin-top: 5px; display: flex; color: #000; border-radius: 5px;">
        <div style="width: 50%;">
            <p style="margin-bottom: 5px;">
                <strong>Purchase Date:</strong> {{ \Carbon\Carbon::parse($sale->created_at)->format('m/d/Y') }} <br>
                <strong>Sale Code:</strong> {{ $sale->reference_no }} <br>
                <strong>Warehouse: </strong> {{ $sale->warehouse?->name }} <br>
                <strong>Note:</strong> {{ $sale->note ?? 'N/A' }} <br>
            </p>
        </div>
        <div style="width: 50%;">
            <p style="margin-bottom: 5px;">
                <strong>Status:</strong> {{ $sale->sale_status == 1 ? 'Completed' : 'Pending' }} </br>
                <strong>Customer:</strong> {{ $sale->customer?->name ?? 'N/A' }}</br>
                <strong>Payment Status:</strong> {{ $sale->payment_status == 1 ? 'Pending' : ($sale->payment_status == 2
                ? 'Due' : ($sale->payment_status == 3 ? 'Partial' : 'Paid')) }}</br>
                <strong>Added By:</strong> {{ $sale->user?->name ?? 'N/A' }}</br>
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
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Code')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Quantity')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Net Unit Price')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Discount')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Tax')}}</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">{{trans('file.Subtotal')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lims_product_sale_data as $index => $product_sale)
            <?php
                $product_data = DB::table('products')->find($product_sale->product_id);
                if($product_sale->variant_id){
                    $product_variant_data = \App\Models\ProductVariant::select('id', 'item_code')->FindExactProduct($product_data->id, $product_sale->variant_id)->first();
                    $product_variant_id = $product_variant_data->id;
                    $product_data->code = $product_variant_data->item_code;
                }
                else
                    $product_variant_id = null;
                if($product_data->tax_method == 1){
                    $product_price = $product_sale->net_unit_price + ($product_sale->discount / $product_sale->qty);
                }
                elseif ($product_data->tax_method == 2) {
                    $product_price =($product_sale->total / $product_sale->qty) + ($product_sale->discount / $product_sale->qty);
                }

                $tax = DB::table('taxes')->where('rate',$product_sale->tax_rate)->first();
                $unit_name = array();
                $unit_operator = array();
                $unit_operation_value = array();
                if($product_data->type == 'standard'){
                    $units = DB::table('units')->where('base_unit', $product_data->unit_id)->orWhere('id', $product_data->unit_id)->get();

                    foreach($units as $unit) {
                        if($product_sale->sale_unit_id == $unit->id) {
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
                    if($unit_operator[0] == '*'){
                        $product_price = $product_price / $unit_operation_value[0];
                    }
                    elseif($unit_operator[0] == '/'){
                        $product_price = $product_price * $unit_operation_value[0];
                    }
                }
                else {
                    $unit_name[] = 'n/a'. ',';
                    $unit_operator[] = 'n/a'. ',';
                    $unit_operation_value[] = 'n/a'. ',';
                }
                $temp_unit_name = $unit_name = implode(",",$unit_name) . ',';

                $temp_unit_operator = $unit_operator = implode(",",$unit_operator) .',';

                $temp_unit_operation_value = $unit_operation_value =  implode(",",$unit_operation_value) . ',';

                $product_batch_data = \App\Models\ProductBatch::select('batch_no', 'expired_date')->find($product_sale->product_batch_id);
            ?>
            <tr>
                <td style="border: 1px solid #000; padding: 5px;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{$product_data->name}}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{$product_data->code}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{$product_sale->qty}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_sale->net_unit_price, $general_setting->decimal, '.', '')}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_sale->discount, $general_setting->decimal, '.', '')}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_sale->tax, $general_setting->decimal, '.', '')}}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format((float)$product_sale->total, $general_setting->decimal, '.', '')}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border: 1px solid #000; padding: 5px;"><strong>Total:</strong>
                </td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    <strong>{{$sale->total_qty}}</strong>
                </td>
                <td></td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    <strong>{{ number_format((float)$sale->total_discount, $general_setting->decimal, '.',
                        '')}}</strong>
                </td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    <strong>{{ number_format((float)$sale->total_tax, $general_setting->decimal, '.', '')}}</strong>
                </td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">
                    <strong>{{ number_format((float)$sale->total_price, $general_setting->decimal, '.', '')}}</strong>
                </td>
            </tr>
        </tbody>
    </table>
</x-invoice-print>
@endsection

@push('scripts')

@endpush