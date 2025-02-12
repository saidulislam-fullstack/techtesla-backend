@extends('backend.layout.main')
@push('styles')
    <style>
        @media print {
            #printBtn {
                display: none;
            }
        }
    </style>
@endpush
@section('content')
    <section id="quotationSection">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.Requested Quotation Show') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="rfq_no">{{ trans('file.RFQ No') }}:</label>
                                {{ $item->rfq_no }}
                            </div>
                            <div class="form-group">
                                <label for="rfq_date">{{ trans('file.Date') }}:</label>
                                {{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}
                            </div>
                            <div class="form-group">
                                <label for="type">{{ trans('file.Type') }}:</label>
                                {{ ucwords(implode(' ', explode('_', $item->type))) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="customer_name">{{ trans('file.Customer Name') }}:</label>
                                {{ $item->customer?->name }}
                            </div>
                            <div class="form-group">
                                <label for="customer_address">{{ trans('file.Customer Address') }}:</label>
                                {{ $item->customer?->address }}
                            </div>
                            <div class="form-group">
                                <label for="customer_phone_number">{{ trans('file.Customer Contact') }}:</label>
                                {{ $item->customer?->phone_number }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.Product') }}</th>
                                        <th>{{ trans('file.Quantity') }}</th>
                                        <th>{{ trans('file.Proposed Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->items as $value)
                                        <tr>
                                            <td>{{ $value->product?->name }}</td>
                                            <td>{{ $value->quantity }}</td>
                                            <td>{{ $value->proposed_price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note">{{ trans('file.Note') }}</label>
                                <textarea class="form-control" id="note" name="note" rows="3" readonly>{{ $item->note }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="delivery_info">{{ trans('file.Delivery Address') }}</label>
                                <textarea class="form-control" id="delivery_info" name="delivery_info" rows="3" readonly>{{ $item->delivery_info }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Print Button -->
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary no-print" id="printBtn"
                    onclick="printQuotation()">Print</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #rf-quotation-list-menu").addClass("active");

        function printQuotation() {
            let printContent = document.getElementById('quotationSection').innerHTML;
            let originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload(); // Reload page to restore event listeners
        }
    </script>
@endpush
