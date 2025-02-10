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
                                            <input type="date" name="date" id="rfq_date" class="form-control"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rfq_type">{{ trans('file.Type') }}</label><span class="required">
                                                *</span>
                                            <select name="type" id="rfq_type" class="selectpicker form-control"
                                                onchange="selectedType(this)" data-live-search="true" title="Select Type..."
                                                required>
                                                <option value="">Select Type</option>
                                                <option value="regular_mro">Regular MRO</option>
                                                <option value="project">Project</option>
                                                <option value="techtesla_stock">TecTesla Stock</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="customer-label">{{ trans('file.customer') }} </label>
                                            <select id="customer_id" name="customer_id" class="selectpicker form-control"
                                                data-live-search="true" id="customer-id" title="Select customer...">
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('file.Note') }}</label>
                                            <textarea rows="5" class="form-control" name="note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ trans('file.Delivery Address') }}</label>
                                            <textarea rows="3" class="form-control" name="delivery_info"></textarea>
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
    <script type="text/javascript">
        var product_list_with_variant = @json($product_list_with_variant);
        var product_list_without_variant = @json($product_list_without_variant);
        var product_array = [];
        var productSearch = $('#productSearch');

        // foreach product with variant and without variant and push into product_array
        // product_list_with_variant.forEach(function(product) {
        //     product_array.push(escapeHtml(product.item_code) + '|' + replaceNewLines(escapeHtml(product.name)) +
        //         '|' + product.id);
        // });
        product_list_without_variant.forEach(function(product) {
            product_array.push(escapeHtml(product.code) + '|' + replaceNewLines(escapeHtml(product.name)) + '|' +
                product.id);
        });

        console.log(product_list_without_variant);
        console.log(product_list_with_variant);


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
            // if search is empty, clear search results
            if (search == '') {
                $('#productSearchResult').html('');
                return;
            }
            var result = product_array.filter(product => product.match(regex));
            var html = '';
            result.slice(0, 10).forEach(function(product) {
                var product = product.split('|');
                html += '<li class="list-group-item product-item" data-code="' + product[0] +
                    '" data-id="' + product[2] + '">' +
                    product[1] +
                    '</li>';
            });
            $('#productSearchResult').html(html);
        });

        // Handle product selection from search results
        $(document).on('click', '.product-item', function() {
            let selectedProduct = $(this).data('code');
            let product = product_array.find(product => product.split('|')[0] == selectedProduct);
            let quantity = 1;
            let proposedPrice = 0;
            // search product in product_array
            let productDetails = product.split('|');
            let productCode = productDetails[0];
            let productName = productDetails[1];
            let productId = productDetails[2];
            $('#productSearchResult').html(''); // Clear search results
            $('#productSearch').val(''); // Clear search input
            // Check if product already exists in the table
            let existingRow = $('#myTable tbody tr').filter(function() {
                return $(this).find('input[name="product_code[]"]').val() == productCode;
            });
            if (existingRow.length > 0) {
                // Product already exists, update quantity
                let currentQuantity = parseInt(existingRow.find('input[name="quantity[]"]').val(), 10);
                existingRow.find('input[name="quantity[]"]').val(currentQuantity + 1);
            } else {
                let row = '<tr>' +
                    '<td>' + productName + '<input type="hidden" name="product_code[]" value="' + productCode +
                    '"><input type="hidden" name="product_id[]" value="' + productId + '" /></td>' +
                    '<td><input type="number" name="quantity[]" class="form-control" value="' + quantity +
                    '" required></td>' +
                    '<td><input type="number" name="proposed_price[]" class="form-control" value="' +
                    proposedPrice +
                    '" required></td>' +
                    '<td><button class="btn btn-danger remove-row"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>';
                // Append the new row to the table
                $('#myTable tbody').append(row);
            }
        });

        // Remove product from the table
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        function escapeHtml(text) {
            if (typeof text !== 'string') {
                return text || '';
            }
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

        function selectedType(e) {
            // if type is project or regular_mro then customer_id is required
            if (e.value == 'project' || e.value == 'regular_mro') {
                // customer-label append * span with class text-danger
                $('.customer-label').append('<span>*</span>');
                $('#customer_id').prop('required', true);
            } else {
                // remove * span from customer-label
                $('.customer-label span').remove();
                $('#customer_id').prop('required', false);
            }
        }
    </script>
@endpush
