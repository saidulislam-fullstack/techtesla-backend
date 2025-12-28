@extends('backend.layout.main')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap');

    .challan-container {
        background: #f7f7f7;
        min-height: 11in;
        padding: 0;
        box-sizing: border-box;
        margin: auto;
    }

    .image-head img {
        margin: 20px 0;
        width: 100%;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1 {
        font-size: 24px;
        font-weight: bold;
        text-decoration: underline;
        margin: 0;
        padding: 0;
    }

    .sub-header {
        margin-bottom: 20px;
        font-size: 14px;
    }

    .delivery-date {
        text-align: right;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .details-section {
        display: flex;
        justify-content: space-between;
        border-top: 2px solid black;
        border-bottom: 2px solid black;
        padding: 10px 0;
    }

    .delivery-to {
        width: 50%;
    }

    .delivery-to p {
        margin: 0;
        font-size: 14px;
    }

    .delivery-info {
        width: 50%;
    }

    .info-table {
        width: 100%;
        font-size: 14px;
    }

    .info-table td {
        padding: 2px 5px;
    }

    .info-table td:first-child {
        font-weight: bold;
        width: 145px;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .items-table th,
    .items-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    .items-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .items-table .item-description {
        text-align: left;
    }

    .signature-section {
        display: flex;
        justify-content: space-between;
        margin-top: 200px;
    }

    .signature {
        width: 45%;
        text-align: center;
        font-size: 14px;
    }

    .signature-line {
        border-top: 2px dashed #000;
        margin-bottom: 5px;
    }

    .bottom-bar {
        margin-top: 30px;
        border-bottom: 1px solid black;
        text-align: right;
        font-weight: bold;
        color: red;
        padding-top: 5px;
    }

    .office {
        text-align: center;
        font-size: 14px;
        margin-top: 8px;
    }

    .office h3 {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<x-invoice-print title="Purchase #{{ $sale->reference_no }}" filename="delivery_chalan_{{ $sale->reference_no }}"
    :header="false" :footer="false">
    <div class="challan-container">
        <div class="image-head">
            <img src="{{ asset('logo/invoice-head.png') }}" alt="Invoice Head">
        </div>
        <div class="header">
            <h1>DELIVERY CHALLAN</h1>
        </div>
        <p class="sub-header">We are pleased to deliver the following described product as per the reference purchase
            order:
        </p>
        <div class="delivery-date">
            <strong>Delivery Date:</strong> {{ $sale->delivery_date ?
            \Carbon\Carbon::parse($sale->delivery_date)->format('d/m/Y') : 'N/A' }}
        </div>
        <table style="border-top: 1px solid black; margin-top: 1px; width: 100%;">
            <tr>
                <td colspan="4" style="border: 1px solid black; padding-left: 5px;"><strong>Delivery To:</strong></td>
                <td colspan="2" style="border: 1px solid black; padding-left: 5px;"><strong>Delivery
                        Information:</strong></td>
            </tr>
            <tr>
                <td colspan="4"
                    style="vertical-align: top; border-left: none; width: 50%; border-right: 1px solid black; padding-left: 5px;">
                    <span style="font-size: 24px;"><strong>{{ $sale->customer?->name ?? 'N/A' }}</strong></span><br>
                    {{ $sale->customer?->address ?? 'N/A' }}. <br>
                    <strong>Phone:</strong> {{ $sale->customer?->contactPersons->first()?->phone ?? 'N/A' }}
                </td>
                <td colspan="2" style="border-right: none; padding-left: 5px;">
                    <strong>Delivery No:</strong> {{ 'DCH-'.date('Ymd').'-'.str_pad($sale->id, 3, '0',
                    STR_PAD_LEFT) }}<br>
                    <strong>Reference:</strong> {{ $sale->reference_no }}<br>
                    <strong>Ref. PO No:</strong> {{ $sale->po_number ?? 'N/A' }}<br>
                    <strong>PO Date:</strong> {{ $sale->po_date ?
                    \Carbon\Carbon::parse($sale->po_date)->format('m/d/Y') : 'N/A' }}<br>
                    <strong>BIN No:</strong> {{ $general_settings->bin_number??'--' }}<br>
                    <strong>TIN No:</strong> {{ $general_settings->vat_registration_number??'--' }}<br>
                </td>
            </tr>
        </table>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">SL.</th>
                    <th style="width: 75%;">ITEM DESCRIPTION</th>
                    <th style="width: 10%;">UNIT</th>
                    <th style="width: 10%;">QUANTITY</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_product_sale_data as $index => $product_sale)
                <?php
                    $product_data = DB::table('products')->find($product_sale->product_id);
                    $brand = DB::table('brands')->find($product_data->brand_id);
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
                    <td>{{$index + 1}}</td>
                    <td class="item-description"><strong>{{ $product_data->name ?? 'N/A' }}</strong>
                        <br><strong>Model:</strong> {{ $product_data->code ?? 'N/A' }}<br>
                        <strong>Brand:</strong> {{ $brand?->title }}<br>
                        <strong>Origin:</strong> {{ $product_data->origin }}
                        <br>{!! $product_data->product_details !!}
                    </td>
                    <td>PCS.</td>
                    <td>{{$product_sale->qty}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature">
                <div class="signature-line"></div>
                Authorized Signature
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                Receiver Signature with Designation, Seal & Date
            </div>
        </div>

        <div class="bottom-bar" style="margin-top: 10vh;">
            www.tecteslabd.com
        </div>
        <div class="office">
            <h3>Chattogram Office (Registered):</h3>
            SH Square, Flat no: C1, Level-2, GEC by Lane, Beside of premier University, Chattogram, Bangladesh.<br><br>
            <h3>Dhaka Office:</h3>
            House No:2/A (1st Floor), Road No:12, Nikunja-2, Khilkhet, Dhaka-1229, Bangladesh.<br>
            +8801970-003031, +8801969-003031, Email: info@tecteslabd.com
        </div>
    </div>
</x-invoice-print>
@endsection

@push('scripts')
@endpush