@extends('backend.layout.main')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tiro+Bangla&family=Roboto:wght@400;700&display=swap');

    /* body {
        font-family: 'Tiro Bangla', 'Roboto', sans-serif;
        font-size: 12px;
        line-height: 1.4;
        color: #000;
        background-color: #fff;
        margin: 20px;
    } */

    .container {
        /* max-width: auto;
        margin: auto;
        border: 1px solid #000;
        padding: 5px; */
        padding-top: 10px;
        background: #2ABCE9;
    }

    .header,
    .footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .header .title-section {
        text-align: center;
    }

    .header .title-section h2 {
        margin: 0;
        font-size: 16px;
        font-weight: bold;
    }

    .header .title-section h3 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
        border: 1px solid #000;
        padding: 2px 5px;
        margin-top: 5px;
    }

    .header .title-section p {
        margin: 5px 0 0 0;
        font-size: 11px;
    }

    .header .copy-info {
        text-align: right;
    }

    .logo {
        width: 60px;
        height: 60px;
        /* Using a placeholder dummy logo */
        background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="%23006a4e" d="M50,3.8c-25.5,0-46.2,20.7-46.2,46.2s20.7,46.2,46.2,46.2s46.2-20.7,46.2-46.2S75.5,3.8,50,3.8z M50,90.2 C27.8,90.2,9.8,72.2,9.8,50S27.8,9.8,50,9.8s40.2,18,40.2,40.2S72.2,90.2,50,90.2z"/><path fill="%23f42a41" d="M50,12.5c-20.7,0-37.5,16.8-37.5,37.5s16.8,37.5,37.5,37.5s37.5-16.8,37.5-37.5S70.7,12.5,50,12.5z"/></svg>');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    .info-section {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        border-top: 1px solid #000;
        padding-top: 10px;
    }

    .info-box {
        width: 48%;
    }

    .info-box p,
    .transport-info p {
        margin: 0 0 5px 0;
    }

    .transport-info {
        margin-top: 5px;
        padding-top: 5px;
        margin-bottom: 20px;
        /* border-top: 1px solid #000;
        border-bottom: 1px solid #000; */
    }

    .main-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    .main-table th,
    .main-table td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
    }

    .main-table th {
        font-weight: normal;
        font-size: 10px;
    }

    .main-table td {
        font-size: 11px;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }

    .totals-section {
        margin-top: 0px;
    }

    .totals-section p {
        margin: 5px 0;
        font-weight: bold;
    }

    .footer {
        margin-top: 200px;
        padding-top: 10px;
        /* border-top: 1px solid #000; */
    }

    .signature-section {
        width: 70%;
    }

    .signature-section p {
        margin: 2px 0;
    }

    .stamp-section {
        width: 30%;
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .stamp {
        border: 2px solid #000;
        border-radius: 50%;
        width: 100px;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        transform: rotate(-15deg);
    }

    .final-note {
        margin-top: 10px;
        font-size: 10px;
        font-style: italic;
    }

    .print-info {
        font-size: 9px;
        margin-top: 20px;
    }

    .bengali {
        font-family: 'Tiro Bangla', serif;
    }

    .english {
        font-family: 'Roboto', sans-serif;
    }
</style>
@endpush

@section('content')
<x-invoice-print title="Purchase #{{ $sale->reference_no }}" filename="vat_chalan_{{ $sale->reference_no }}"
    :header="false" :footer="false">
    <div class="container">
        <div class="header">
            <div class=""><img style="max-width: 50px;" src="{{asset('goprb.png')}}" alt=""></div>
            <div class="title-section">
                <h2 class="bengali">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h2>
                <h2 class="bengali">জাতীয় রাজস্ব বোর্ড</h2>
                <h3 class="bengali">কর চালানপত্র</h3>
                <p class="bengali">[বিধি ৪০ এর উপ-বিধি (১) এর দফা (গ) ও দফা (চ) দ্রষ্টব্য]</p>
            </div>
            <div class="copy-info">
                <p class="bengali">প্রথম কপি/দ্বিতীয় কপি</p>
                <p class="bengali">মুশক-৬.৩</p>
            </div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <p><span class="bengali">নিবন্ধিত ব্যক্তির নাম:</span> <span
                        class="english">{{$general_settings->company_name??'--'}}</span></p>
                <p><span class="bengali">নিবন্ধিত ব্যক্তির বিআইএন:</span> <span class="english">001090653-0103</span>
                </p>
                <p><span class="bengali">চালানপত্র ইস্যুর ঠিকানা:</span> <span class="english">{{
                        $sale->warehouse?->address }}.</span></p>
            </div>
        </div>

        <div class="info-section" style="border-top: none; padding-top: 0;">
            <div class="info-box" style="width: 65%;">
                <p><span class="bengali">ক্রেতার নাম:</span> <span class="english">{{ $sale->customer?->name ?? 'N/A'
                        }}</span></p>
                <p><span class="bengali">ক্রেতার বিআইএন (প্রযোজ্যক্ষেত্রে):</span> <span class="english">{{
                        $sale->customer?->bin_number ?? 'N/A'
                        }}</span></p>
                <p><span class="bengali">ক্রেতার ঠিকানা:</span> <span class="english">{{ $sale->customer?->address ??
                        'N/A'
                        }}</span></p>
                <p><span class="bengali">সরবরাহের গন্তব্যস্থল:</span> <span class="english">{{ $sale->customer?->address
                        ?? 'N/A'
                        }}</span></p>
            </div>
            <div class="info-box" style="width: 35%;">
                <p><span class="bengali">চালানপত্র নম্বর:</span> <span class="english">{{$sale->reference_no}}</span>
                </p>
                <p><span class="bengali">ইস্যুর তারিখ:</span> <span class="english">{{
                        $sale->created_at->format('d/m/Y') }}</span></p>
                <p><span class="bengali">ইস্যুর সময়:</span> <span class="english">{{ $sale->created_at->format('h:i:s
                        A') }}</span></p>
            </div>
        </div>

        <div class="transport-info">
            <p><span class="bengali">যানবাহনের প্রকৃতি ও নম্বর:</span> <span class="english">--</span></p>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th class="bengali">ক্রমিক নং</th>
                    <th class="bengali" style="width: 25%;">পণ্য/সেবার বর্ণনা<br>(প্রযোজ্যক্ষেত্রে ব্র্যান্ড নামসহ)</th>
                    <th class="bengali">সরবরাহের একক</th>
                    <th class="bengali">পরিমাণ</th>
                    <th class="bengali">একক মূল্য<br>( টাকায়)</th>
                    <th class="bengali">মোট মূল্য<br>(টাকায়)</th>
                    <th class="bengali">সম্পূরক<br>শুল্কের<br>হার</th>
                    <th class="bengali">সম্পূরক<br>শুল্কের পরিমাণ<br>(টাকায়)</th>
                    <th class="bengali">মূল্য সংযোজন<br>করের হার/<br>সুনির্দিষ্ট কর</th>
                    <th class="bengali">মূসক/<br>টার্নওভার<br>করের পরিমাণ<br>(টাকায়)</th>
                    <th class="bengali">সকল প্রকার শুল্ক<br>ও করসহ বিক্রয়<br>মূল্য</th>
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
                    $temp_unit_name = $unit_name = implode(",",$unit_name);

                    $temp_unit_operator = $unit_operator = implode(",",$unit_operator) .',';

                    $temp_unit_operation_value = $unit_operation_value =  implode(",",$unit_operation_value) . ',';

                    $product_batch_data = \App\Models\ProductBatch::select('batch_no', 'expired_date')->find($product_sale->product_batch_id);

                    $product_vat_tax = ($product_sale->total * $sale->order_tax_rate) / 100;
                ?>
                <tr>
                    <td>1</td>
                    <td class="text-left english">{{$product_data->name}}</td>
                    <td class="english">{{ $temp_unit_name }}</td>
                    <td class="text-right english">{{ $product_sale->qty }}</td>
                    <td class="text-right english">{{
                        number_format((float)$product_sale->net_unit_price, $general_setting->decimal, '.', '')}}</td>
                    <td class="text-right english">{{
                        number_format(((float)$product_sale->net_unit_price) * $product_sale->qty,
                        $general_setting->decimal, '.', '')}}</td>
                    <td class="text-right english">0.00</td>
                    <td class="text-right english">0.00</td>
                    <td class="text-right english">{{ $sale->order_tax_rate ?? 0 }}%</td>
                    <td class="text-right english">{{
                        number_format((float)$product_vat_tax, $general_setting->decimal, '.', '')}}</td>
                    <td class="text-right english">{{
                        number_format((float)$product_sale->total + $product_vat_tax, $general_setting->decimal, '.', '')}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3">সর্বমোট</td>
                    <td class="text-right">{{ $sale->total_qty }}</td>
                    <td></td>
                    <td class="text-right">{{ number_format((float)$sale->total_price, $general_setting->decimal, '.',
                        '') }}</td>
                    <td></td>
                    <td class="text-right">0</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{ $sale->order_tax ?? 0 }}</td>
                    <td class="text-right">{{ number_format((float)$sale->grand_total, $general_setting->decimal, '.',
                        '') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="totals-section">
            @php
            $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
            $amount = number_format((float)$sale->grand_total, $general_setting->decimal, '.', '');
            $amountInWords = $formatter->format($amount);

            $quantity = number_format((float)$sale->total_qty, $general_setting->decimal, '.', '');
            $quantityInWords = $formatter->format($amount);

            @endphp
            <p class=" mt-3">TOTAL QTY: {{ ucfirst($quantity) }}</p>
            <p class="">TAKA: {{ ucfirst($amountInWords) }} only.</p>
        </div>

        <div class="footer">
            <div class="signature-section">
                <p><span class="bengali">প্রতিষ্ঠানের দায়িত্বপ্রাপ্ত ব্যক্তির</span></p>
                <p><span class="bengali">নাম:</span> <span class="english">_ _ _ _ _ _ _ _ _ _ _ _</span></p>
                <p><span class="bengali">পদবী:</span> <span class="english">_ _ _ _ _ _ _ _ _ _ _</span></p>
                <p style="margin-top: 25px;"><span class="bengali">স্বাক্ষর:</span> _________________________</p>
                <p class="final-note bengali">*"এই চালানটি কর চালানপত্র হিসাবে গণ্য হবে"</p>
            </div>
            {{-- <div class="stamp-section">
                <div class="stamp">
                    <span>ABB LIMITED<br>Dhaka<br>Bangladesh</span>
                </div>
            </div> --}}
        </div>
        <p class="print-info english">Printed on: MAR-20-25 11:45 AM</p>
    </div>
</x-invoice-print>
@endsection

@push('scripts')
@endpush