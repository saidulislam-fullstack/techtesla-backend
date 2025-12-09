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

    .delivery-to {
        width: 50%;
    }

    .delivery-to p {
        margin: 0;
        font-size: 14px;
    }

    .info {
        margin-top: 5px;
        margin-bottom: 10px;
    }

    .info table {
        width: 100%;
        border-collapse: collapse;
    }

    .info td {
        padding: 3px;
        vertical-align: top;
    }

    .quotation-box {
        /* border: 1px solid #000; */
        /* padding: 10px; */
    }

    .quotation-box table {
        width: 100%;
        border-collapse: collapse;
    }

    .quotation-box th,
    .quotation-box td {
        border: 1px solid #000;
        padding: 0px 3px !important;
        text-align: left;
    }

    .quotation-box .item-table th {
        background: #d9d9d9;
    }

    .amount-table {
        width: 50%;
        float: right;
        border-collapse: collapse;
    }

    .amount-table th,
    .amount-table td {
        border: 1px solid #000;
        padding: 5px;
        text-align: right;
        border-top: none;
    }

    .footer {
        clear: both;
        margin-top: 50px;
        font-size: 13px;
    }

    .signature {
        margin-top: 20px;
        text-align: left;
    }

    .footer-note {
        margin-top: 10px;
        font-size: 12px;
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

    .term-conditions td {
        border: none;
        padding: 0 6px !important;
    }
</style>
@endpush

@section('content')
<x-invoice-print title="Request for Quotation #{{ $sale->id }}" filename="SaleInvoice_{{ $sale->id }}" :header="false"
    :footer="false">
    <div class="challan-container">
        <div class="image-head">
            <img src="{{ asset('logo/invoice-head.png') }}" alt="Invoice Head">
        </div>
        <div class="header">
            <h1>INVOICE</h1>
        </div>
        <p class="sub-header">We are pleased to submit a invoice for the following described products as per the
            reference purchase order:
        </p>
        <div class="delivery-date">
            <strong>Purchase Date:</strong> {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y') }}
        </div>

        <div class="quotation-box">
            {{-- <div style="border-top: 1px solid black; font-size: 14px;">
                <strong>Price Quotation for Electrical Spare</strong>
                <strong>Price Quotation for Electrical Spare</strong>
            </div> --}}
            <table style="border-top: 1px solid black; margin-top: 1px;">
                <tr>
                    <td colspan="4"><strong>Invoice To:</strong></td>
                    <td colspan="2"><strong>Invoice Information:</strong></td>
                </tr>
                <tr>
                    <td colspan="4" style="vertical-align: top; border-left: none; width: 50%;">
                        <span style="font-size: 24px;"><strong>{{ $sale->customer?->name ?? 'N/A' }}</strong></span><br>
                        {{ $sale->customer?->address ?? 'N/A' }}. <br>
                        <strong>Phone:</strong> {{ $sale->customer?->contactPersons->first()?->phone ?? 'N/A' }}
                    </td>
                    <td colspan="2" style="border-right: none;">
                        <strong>Reference / Invoice No:</strong> {{ $sale->reference_no }}<br>
                        <strong>Ref. PO No:</strong> {{ $sale->rfq?->purchases->first()?->reference_no ?? 'N/A' }}<br>
                        <strong>PO Date:</strong> {{ $sale->rfq?->purchases->first() ?
                        \Carbon\Carbon::parse($sale->rfq?->purchases->first()?->created_at
                        )->format('m/d/Y') : 'N/A' }}<br>
                        <strong>BIN No:</strong> {{ $sale->customer?->bin_number ?? '--' }}<br>
                        <strong>TIN No:</strong> {{ $sale->customer?->tax_no ?? '--' }}<br>
                    </td>
                </tr>
            </table>

            <table class="item-table">
                <tr>
                    <th style="width:5%; border-top: none">SL.</th>
                    <th style="width:45%; border-top: none">ITEM DESCRIPTION</th>
                    <th style="width:10%; border-top: none">UNIT</th>
                    <th style="width:15%; border-top: none">QUANTITY</th>
                    <th style="width:15%; border-top: none">UNIT PRICE</th>
                    <th style="width:15%; border-top: none">TOTAL PRICE</th>
                </tr>
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
                    $temp_unit_name = $unit_name = implode(",",$unit_name);

                    $temp_unit_operator = $unit_operator = implode(",",$unit_operator) .',';

                    $temp_unit_operation_value = $unit_operation_value =  implode(",",$unit_operation_value) . ',';

                    $product_batch_data = \App\Models\ProductBatch::select('batch_no', 'expired_date')->find($product_sale->product_batch_id);
                ?>
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $product_data->name }}</strong><br>
                        <strong>Model:</strong> {{ $product_data->code }}<br>
                        <strong>Brand:</strong> {{ $brand?->title }}<br>
                        <strong>Origin:</strong> {{ $product_data->origin }}<br>
                        {!! $product_data->product_details?? '' !!}
                    </td>
                    <td>{{ $temp_unit_name }}</td>
                    <td class="text-right">{{$product_sale->qty}}</td>
                    <td class="text-right">{{ number_format((float)$product_sale->net_unit_price,
                        $general_setting->decimal, '.', '') }}
                    </td>
                    <td class="text-right">{{ number_format((float)$product_sale->total, $general_setting->decimal, '.',
                        '')}}</td>
                </tr>
                @endforeach
            </table>

            <table class="amount-table">
                <tr>
                    <th style="border-right: none">TOTAL AMOUNT (BDT)</th>
                    <th style="border-left: none; border-right: none;">=</th>
                    <td style="border-left: none;">{{ number_format((float)$sale->total_price,
                        $general_setting->decimal, '.', '') }}</td>
                </tr>
                <tr>
                    <th style="border-right: none">VAT (BDT)</th>
                    <th style="border-left: none; border-right: none;">=</th>
                    <td style="border-left: none;">{{ number_format((float)$sale->order_tax, $general_setting->decimal,
                        '.', '')}}</td>
                </tr>
                <tr>
                    <th style="border-right: none">SHIPPING COST (BDT)</th>
                    <th style="border-left: none; border-right: none;">=</th>
                    <td style="border-left: none;">{{ number_format((float)$sale->shipping_cost,
                        $general_setting->decimal,
                        '.', '')}}</td>
                </tr>
                <tr>
                    <th style="border-right: none">GRAND TOTAL (BDT)</th>
                    <th style="border-left: none; border-right: none;">=</th>
                    <td style="border-left: none;"><strong>{{ number_format((float)$sale->grand_total,
                            $general_setting->decimal, '.', '') }}</strong></td>
                </tr>
            </table>
            <div style="clear:both;"></div>
            <p>
                <strong>
                    In Words:
                    @php
                    $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
                    echo ucfirst($f->format($sale->grand_total));
                    @endphp
                </strong>
            </p>

            <div class="signature d-flex justify-content-between" style="margin-top: 20vh;">
                <p><strong>______________________<br>Authorized Signature</strong></p>
                <p><strong>______________________<br>Receiver's Signature</strong></p>
            </div>

        </div>

        <div class="bottom-bar" style="margin-top: 10vh;">
            www.tecteslabd.com
        </div>
        <div class="office">
            <h3>Chattogram Office (Registered):</h3>
            Standard City Plaza (6th Floor), 533/536 Sheikh Mujib Road, Double Mooring,
            Chattogram-4100, Bangladesh.<br><br>
            <h3>Dhaka Office:</h3>
            House No:2/A (1st Floor), Road No:12, Nikunja-2, Khilkhet, Dhaka-1229, Bangladesh.<br>
            +8801970-003031, +8801969-003031, Email: info@tecteslabd.com
        </div>
    </div>
</x-invoice-print>
@endsection

@push('scripts')

@endpush