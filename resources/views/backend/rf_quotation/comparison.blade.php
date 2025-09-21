@extends('backend.layout.main')

@push('styles')

@endpush

@section('content')
<x-invoice-print title="Request for Quotation #{{ $item->rfq_no }}" filename="RFQ_{{ $item->rfq_no }}" :header="true" :footer="false">
    <!-- RFQ Details -->
    <h1 class="text-center">Stock Comparison Sheet</h1>    
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
                <th style="border: 1px solid #000; padding: 10px 5px;">Required Qty</th>
                <th style="border: 1px solid #000; padding: 10px 5px;">Available Qty</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQty = 0; @endphp
            @foreach ($item->items as $index => $value)
            <tr style="background: {{ $value->quantity > ($value->product?->qty ?? 0) ? '#f58e8e' : '#80f69f' }}">
                <td style="border: 1px solid #000; padding: 5px;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->product?->code }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->product?->name }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->product?->description ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; padding: 5px;">{{ $value->uom ?? 'PCS' }}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{ number_format($value->quantity, 3) }}</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">{{ number_format($value->product?->qty, 3) }}</td>
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
    </table>
</x-invoice-print>
@endsection

@push('scripts')

@endpush