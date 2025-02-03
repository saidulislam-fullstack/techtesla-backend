@extends('backend.layout.main')
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Update RFQuotation') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <form action="{{ route('rf-quotation.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rfq_date">{{ trans('file.Date') }}</label><span class="required">
                                                *</span>
                                            <input type="date" name="date" id="rfq_date" class="form-control"
                                                value="{{ $item->date }}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rfq_type">{{ trans('file.Type') }}</label><span class="required">
                                                *</span>
                                            <select name="type" id="rfq_type" class="selectpicker form-control"
                                                data-live-search="true" title="Select Type..." required>
                                                <option value="">Select Type</option>
                                                <option value="1" @selected($item->type == 1)>Regular MRO</option>
                                                <option value="2" @selected($item->type == 2)>Project</option>
                                                <option value="3" @selected($item->type == 3)>TecTesla Stock</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('file.customer') }} </label>
                                            <select id="customer_id" name="customer_id" class="selectpicker form-control"
                                                data-live-search="true" id="customer-id" title="Select customer...">
                                                @foreach ($customer_list as $customer)
                                                    <option value="{{ $customer->id }}" @selected($item->customer_id == $customer->id)>
                                                        {{ $customer->name . ' (' . $customer->phone_number . ')' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('file.Attach Document') }}</label> <i class="dripicons-question"
                                                data-toggle="tooltip"
                                                title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                            <input type="file" name="document" class="form-control" />
                                            @isset($item->document)
                                                <a href="{{ asset($item->document) }}" target="_blank">View Document</a>
                                            @endisset
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label>{{ trans('file.Select Product') }}</label>
                                        <div class="search-box input-group">
                                            <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_name" id="productSearch"
                                                placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                        <ul id="productSearchResult" class="list-group mt-1"></ul>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h5>{{ trans('file.Order Table') }} *</h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('file.Product') }}</th>
                                                        <th>{{ trans('file.Quantity') }}</th>
                                                        <th>{{ trans('file.Proposed Price') }}</th>
                                                        <th>{{ trans('file.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($item->items as $order)
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="product_id[]"
                                                                    value="{{ $order->product_id }}" />
                                                                {{ $order->product->name }}
                                                            </td>
                                                            <td>
                                                                <input type="number" name="quantity[]" class="form-control"
                                                                    value="{{ $order->quantity }}" required />
                                                            </td>
                                                            <td>
                                                                <input type="number" name="price[]" class="form-control"
                                                                    value="{{ $order->price }}" required />
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger remove-row">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('file.Note') }}</label>
                                            <textarea rows="5" class="form-control" name="note">{{ $item->note }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('file.Delivery Address') }}</label>
                                            <textarea rows="3" class="form-control" name="delivery_info">{{ $item->delivery_info }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="{{ trans('file.submit') }}"
                                                class="btn btn-primary" id="submit-button" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
