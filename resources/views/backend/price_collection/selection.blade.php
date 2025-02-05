@extends('backend.layout.main')
@section('content')
    <section class="forms">
        <div class="container-fluid">
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
                                                <th>{{ trans('file.Customer Proposed Price') }}</th>
                                                <th>{{ trans('file.Supplier') }}</th>
                                                <th>{{ trans('file.Market Price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="item_id[]" @checked($item->is_selected)
                                                            value="{{ $item->id }}">
                                                    </td>
                                                    <td>{{ $item->product?->name }}</td>
                                                    <td>{{ $item->rfqItem?->proposed_price }}</td>
                                                    <td>{{ $item->supplier?->name }}</td>
                                                    <td>{{ $item->price }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary btn-sm">{{ trans('file.Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
