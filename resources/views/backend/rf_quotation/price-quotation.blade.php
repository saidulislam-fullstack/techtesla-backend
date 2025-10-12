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
        border: 1px solid #000;
        padding: 10px;
    }

    .quotation-box table {
        width: 100%;
        border-collapse: collapse;
    }

    .quotation-box th,
    .quotation-box td {
        border: 1px solid #000;
        padding: 5px;
        text-align: left;
    }

    .quotation-box th {
        background: #f3f3f3;
    }

    .amount-table {
        margin-top: 5px;
        width: 50%;
        float: right;
        border-collapse: collapse;
    }

    .amount-table th,
    .amount-table td {
        border: 1px solid #000;
        padding: 5px;
        text-align: right;
    }

    .footer {
        clear: both;
        margin-top: 50px;
        font-size: 13px;
    }

    .signature {
        margin-top: 60px;
        text-align: left;
    }

    .footer-note {
        margin-top: 10px;
        font-size: 12px;
    }

    .bottom-bar {
        margin-top: 30px;
        border-top: 3px solid red;
        text-align: center;
        font-weight: bold;
        color: red;
        padding-top: 5px;
    }

    .office {
        text-align: center;
        font-size: 11px;
        margin-top: 8px;
    }
</style>
@endpush

@section('content')
<x-invoice-print title="Request for Quotation #{{ $item->rfq_no }}" filename="RFQ_{{ $item->rfq_no }}" :header="false"
    :footer="false">
    <div class="challan-container">
        <div class="image-head">
            <img src="{{ asset('logo/invoice-head.png') }}" alt="Invoice Head">
        </div>
        <div class="header">
            <h1>QUOTATION</h1>
        </div>
        <p class="sub-header">We are pleased to submit a quotation for the following commodities described on the term &
            conditions specified here under::
        </p>
        <div class="delivery-date">
            <strong>Quotation Date:</strong> {{ \Carbon\Carbon::parse($item->date)->format('m/d/Y') }}
        </div>

        <div class="quotation-box">
            <table>
                <tr>
                    <td colspan="4"><strong>Price Quotation for Electrical Spare</strong><br>
                        <b>BSRM Group of Companies</b><br>
                        Corporate Office, Ali Mansion, 1207/1099, Sadarghat Road, Chittagong, Bangladesh.
                    </td>
                    <td colspan="2">
                        <strong>Quotation No:</strong> {{ $item->rfq_no }}<br>
                        <strong>Customer PR:</strong> N/A<br>
                        <strong>Prepared By:</strong> {{ $item->addedBy?->name ?? 'N/A' }}<br>
                        <strong>Through:</strong> TTCL Chattogram<br>
                        <strong>Mobile:</strong> +88 0197003031<br>
                        <strong>Email:</strong> sohel@tecteslabd.com
                    </td>
                </tr>
            </table>

            <table style="margin-top:10px;">
                <tr>
                    <th style="width:5%;">SL.</th>
                    <th style="width:45%;">ITEM DESCRIPTION</th>
                    <th style="width:10%;">UNIT</th>
                    <th style="width:15%;">QUANTITY</th>
                    <th style="width:15%;">UNIT PRICE</th>
                    <th style="width:15%;">TOTAL PRICE</th>
                </tr>
                @php
                $totalQty = 0;
                $totalPrice = 0;
                @endphp
                @foreach ($item->items as $index => $value)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $value->product?->name }}<br>
                        Model: {{ $value->product?->model }}<br>
                        Delivery time: {{ optional(collect($item->priceCollection)->where('rfq_item_id',
                        $value->id))->first()->delivery_days ?? '-' }} Days<br>
                    </td>
                    <td>Pcs</td>
                    <td>{{ $value->quantity }}</td>
                    <td>{{ optional(collect($item->priceCollection)->where('rfq_item_id',
                        $value->id))->first()?->total_cost ?? '--' }}</td>
                    <td>{{ (optional(collect($item->priceCollection)->where('rfq_item_id',
                        $value->id))->first()?->total_cost * $value->quantity) ?? '--' }}</td>
                </tr>
                @php
                $totalQty += $value->quantity;
                $totalPrice += optional(collect($item->priceCollection)->where('rfq_item_id',
                $value->id))->first()?->total_cost * $value->quantity
                @endphp
                @endforeach
            </table>

            <table class="amount-table">
                <tr>
                    <th>TOTAL AMOUNT (BDT)</th>
                    <td>{{ $totalPrice }}</td>
                </tr>
                {{-- <tr>
                    <th>10% VAT (BDT)</th>
                    <td>1,280.00</td>
                </tr> --}}
                <tr>
                    <th>GRAND TOTAL (BDT)</th>
                    <td><strong>{{ $totalPrice }}</strong></td>
                </tr>
            </table>

            <div style="clear:both;"></div>
            <p><strong>In Words:</strong>
                @php
                $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
                echo ucfirst($f->format($totalPrice));
                @endphp
            </p>

            <p><strong>Payment Term:</strong> Upon finalizing the matter 100% advance payments required with purchase
                order.<br>
                <strong>Price Validity:</strong> 15 Days Only<br>
                <strong>Warranty:</strong> 12 Months Standard Warranty for all products from the date of delivery for
                manufacturing fault only.<br>
                <strong>Suspension of Installation:</strong> Applicable<br>
                <strong>Supervision Works:</strong> Included<br>
                <strong>VAT:</strong> Included<br>
                <strong>TAX:</strong> Included<br>
                <strong>TAXAIT:</strong> Included<br><br>

                We have selected the instrument according to the specifications given, however we kindly ask you to
                thoroughly check the technical data as per your application. Installation service will be provided after
                full payment.<br><br>
                Thank you for your trust in TecTesla Technologies Limited.
            </p>

            <div class="signature">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Signature_example.svg/200px-Signature_example.svg.png"
                    width="100" alt="signature"><br>
                <strong>Engr. Md. Mohsin Sohel – Managing Director</strong><br>
                TecTesla Technologies Limited.
            </div>
        </div>

        <div class="bottom-bar">
            www.tecteslabd.com
        </div>
        <div class="office">
            Chattogram Office (Registered): Standard City Plaza (6th Floor), 533/536 Sheikh Mujib Road, Double Mooring,
            Chattogram-4100, Bangladesh.<br>
            Dhaka Office: House No:2/A (1st Floor), Road No:12, Nikunja-2, Khilkhet, Dhaka-1229, Bangladesh.<br>
            +8801970-003031, +8801969-003031, Email: info@tecteslabd.com
        </div>
    </div>








    {{--
    <!-- RFQ Details -->
    <div style="border: 1px solid #000; padding: 5px; margin-top: 5px; display: flex; color: #000; border-radius: 5px;">
        <div style="width: 50%;">
            <p style="margin-bottom: 5px;">
                <strong>RFQ Date:</strong> {{ \Carbon\Carbon::parse($item->date)->format('m/d/Y') }} <br>
                <strong>RFQ Code:</strong> {{ $item->rfq_no }} <br>
                <strong>Type: </strong> {{ $item->type == 'regular_mro' ? 'Regular MRO' : ($item->type == 'project'
                ? 'Project' : 'TechTesla Stock') }} <br>
                <strong>Note:</strong> {{ $item->note ?? 'N/A' }} <br>
            </p>
        </div>
        <div style="width: 50%;">
            <p style="margin-bottom: 5px;">
                <strong>Status:</strong> {{ ucfirst($item->status ?? 'Pending') }}</br>
                <strong>Created By:</strong> {{ $item->addedBy?->name ?? 'N/A' }}</br>
                <strong>Expected Date:</strong> {{ \Carbon\Carbon::parse($item->expected_date ??
                $item->date)->format('m/d/Y') }}</br>
                <strong>Urgency:</strong> {{ ucfirst($item->urgency ?? 'Medium') }}
            </p>
        </div>
    </div>

    <!-- Item Table -->
    <h6 style="margin-top: 1rem; color: #000;"><strong>Item</strong></h6>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; color: #000;">
        <thead>
            <tr style="background-color: #d3d3d3;">
                <th style="border: 1px solid #000; padding: 10px 5px;">SL</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">Item Code</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">Item Name</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">Item Desc</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">UoM</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">Qty</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQty = 0; @endphp
            @foreach ($item->items as $index => $value)
            <tr>
                <td style="border: 1px solid #000; padding: 5px;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->product?->code }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->product?->name }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->product?->description ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->uom ?? 'PCS' }}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{
                    number_format($value->quantity, 3) }}</td>
            </tr>
            @php $totalQty += $value->quantity; @endphp
            @endforeach
            <tr>
                <td colspan="5" style="border: 1px solid #000; padding: 5px; text-align: right;"><strong>Total
                        Qty:</strong></td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;"><strong>{{
                        number_format($totalQty, 3) }}</strong></td>
            </tr>
        </tbody>
    </table> --}}
</x-invoice-print>
@endsection

@push('scripts')

@endpush