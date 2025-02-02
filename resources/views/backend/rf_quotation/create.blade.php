@extends('backend.layout.main')
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Add RFQuotation') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <form action="{{ route('rf-quotation.store') }}" method="POST" enctype="multipart/form-data"
                                id="rf-quotation-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rfq_date">{{ trans('file.Date') }}</label><span class="required">
                                                *</span>
                                            <input type="date" name="rfq_date" id="rfq_date" class="form-control"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rfq_type">{{ trans('file.Type') }}</label><span class="required">
                                                *</span>
                                            <select name="rfq_type" id="rfq_type" class="selectpicker form-control"
                                                data-live-search="true" title="Select Type..." required>
                                                <option value="">Select Type</option>
                                                <option value="1">Regular MRO</option>
                                                <option value="2">Project</option>
                                                <option value="3">TecTesla Stock</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{ trans('file.customer') }} </label>
                                            <select id="customer_id" name="customer_id" required
                                                class="selectpicker form-control" data-live-search="true" id="customer-id"
                                                title="Select customer...">
                                                @foreach ($customer_list as $customer)
                                                    <option value="{{ $customer->id }}">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('file.Note') }}</label>
                                            <textarea rows="5" class="form-control" name="note"></textarea>
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

        <div class="container-fluid">
            <table class="table table-bordered table-condensed totals">
                <td>
                    <strong>{{ trans('file.Items') }}</strong>
                    <span class="pull-right" id="item"></span>
                </td>
            </table>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        var product_list_with_variant = @json($product_list_with_variant);
        var product_list_without_variant = @json($product_list_without_variant);
        var product_array = [];
        var productSearch = $('#productSearch');

        // foreach product with variant and without variant and push into product_array
        product_list_with_variant.forEach(function(product) {
            product_array.push(escapeHtml(product.code) + '|' + replaceNewLines(escapeHtml(product.name)));
        });
        product_list_without_variant.forEach(function(product) {
            product_array.push(escapeHtml(product.code) + '|' + replaceNewLines(escapeHtml(product.name)));
        });

        console.log(product_list_without_variant);


        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #rf-quotation-create-menu").addClass("active");

        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });

        // search product
        productSearch.on('input', function() {
            var search = $(this).val();
            var regex = new RegExp(search, 'i');
            var result = product_array.filter(product => product.match(regex));
            var html = '';
            result.slice(0, 10).forEach(function(product) {
                var product = product.split('|');
                html += '<li class="list-group-item product-item" data-code="' + product[0] + '">' +
                    product[1] +
                    '</li>';
            });
            $('#productSearchResult').html(html);
        });

        // Handle product selection from search results
        $(document).on('click', '.product-item', function() {
            var selectedProduct = $(this).data('code');
            productSearch.val(selectedProduct); // Set input value to selected product code
            $('#productSearchResult').html(''); // Clear search results
        });

        function escapeHtml(text) {
            return text.replace(/[&<>"']/g, function(char) {
                const escapeMap = {
                    '&': "&amp;",
                    '<': "&lt;",
                    '>': "&gt;",
                    '"': "&quot;",
                    "'": "&#039;"
                };
                return escapeMap[char];
            });
        }

        function replaceNewLines(text) {
            return text.replace(/[\n\r]/g, "<br>");
        }
    </script>
@endpush
