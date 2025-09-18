@extends('backend.layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rfq_id">{{ trans('file.RFQ') }}</label><span class="required">
                        *</span>
                    <select name="rfq_id" id="rfq_id" class="form-control selectpicker" data-live-search="true"
                        onchange="getRfq(this)" required>
                        <option value="">{{ trans('file.Select RFQ') }}</option>
                        @foreach ($rfqList as $item)
                        <option value="{{ $item->id }}" @selected(($rfq->id ?? null) == $item->id)>
                            {{ $item->rfq_no }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @if($rfq)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{ trans('file.Price Collect Selection') }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic">
                            <small>{{ trans('file.After submission selection will be effected on RFQ') }}.</small>
                        </p>
                        <form action="{{ route('price-collection.selection.store', $rfq->id) }}" method="post">
                            @csrf
                            {{-- table for price collection selection --}}
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('file.Select') }}</th>
                                            <th>{{ trans('file.Product') }}</th>
                                            <th>{{ trans('file.Supplier') }}</th>
                                            <th>Delivery Days</th>
                                            <th>{{ trans('file.Customer Proposed Price') }}</th>
                                            <th>{{ trans('file.Market Price') }}</th>
                                            <th>Others Cost</th>
                                            <th>Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $product_id => $product_items)
                                        <tr>
                                            <td colspan="5" class="text-center font-weight-bold">
                                                Product: {{ $product_items->first()->product?->name }}
                                            </td>
                                        </tr>
                                        @foreach ($product_items as $item)
                                        <tr>
                                            <td>
                                                <input type="radio" name="item_id[{{ $product_id }}]"
                                                    @checked($item->is_selected) value="{{ $item->id }}">
                                            </td>
                                            <td>{{ $item->product?->name }}</td>
                                            <td>{{ $item->supplier?->name }}</td>
                                            <td>{{ $item->delivery_days }} Days</td>
                                            <td>{{ $item->rfqItem?->proposed_price }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->other_cost }}</td>
                                            <td>{{ $item->total_cost }}</td>
                                        </tr>
                                        @endforeach
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">{{ trans('file.Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    $("ul#price-collection").siblings('a').attr('aria-expanded', 'true');
    $("ul#price-collection").addClass("show");
    $("ul#price-collection #price-selection-menu").addClass("active");
    $('.selectpicker').selectpicker({
        style: 'btn-link',
    });

    $('#rfq_id').change(function(){
        var rfq_id = $(this).val();
        if(rfq_id){
            window.location = "{{ url('price-collection/selection') }}/"+rfq_id;
        }
    });
</script>
@endpush