@extends('backend.layout.main')
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Add Price Collection') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <form method="post" action="{{ route('price-collection.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rfq_id">{{ trans('file.RFQ') }}</label><span class="required">
                                                *</span>
                                            <select name="rfq_id" id="rfq_id" class="form-control selectpicker"
                                                onchange="getRfq(this)" required>
                                                <option value="">{{ trans('file.Select RFQ') }}</option>
                                                @foreach ($rfqs as $item)
                                                    <option value="{{ $item->id }}" @selected(request()->rfq_id == $item->id)>
                                                        {{ $item->rfq_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group" id="productResultUl">
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <label>{{ trans('file.Select Product') }}</label>
                                        <div class="search-box input-group">
                                            <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                            <input type="text" id="productSearch"
                                                placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                        <ul id="productSearchResult" class="list-group mt-1"></ul>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h5>{{ trans('file.Collection Table') }} *</h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('file.Product') }}</th>
                                                        <th>{{ trans('file.Supplier') }}</th>
                                                        <th>{{ trans('file.Note') }}</th>
                                                        <th>{{ trans('file.Supplier Price') }}</th>
                                                        <th>{{ trans('file.Currency') }}</th>
                                                        <th>{{ trans('file.Currency Rate') }}</th>
                                                        <th>{{ trans('file.Shipping Weight') }}</th>
                                                        <th>{{ trans('file.Customs Unit Cost') }}</th>
                                                        <th>{{ trans('file.Customs Total Cost') }}</th>
                                                        <th>{{ trans('file.Profit Percentage') }}</th>
                                                        <th>{{ trans('file.Profit Amount') }}</th>
                                                        <th>{{ trans('file.Tax Amount') }}</th>
                                                        <th>{{ trans('file.Vat Amount') }}</th>
                                                        <th>{{ trans('file.Other Cost') }}</th>
                                                        <th>{{ trans('file.Total Cost') }}</th>
                                                        <th>{{ trans('file.Recommended Origin') }}</th>
                                                        <th>{{ trans('file.Delivery Days') }}</th>
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
    <!-- Calculation Modal -->
    <div class="modal fade" id="calculationModal" tabindex="-1" role="dialog" aria-labelledby="calculationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calculationModalLabel">Additional Calculations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="calculationForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currencyModal">{{ trans('file.Currency') }}</label>
                                    <select name="currencyModal" id="currencyModal" class="form-control selectpicker">
                                        <option value="">{{ trans('file.Select Currency') }}</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currencyRateModal">{{ trans('file.Currency Rate') }}</label>
                                    <input type="number" id="currencyRateModal" class="form-control" step="0.01"
                                        value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profitMarginModal">Profit Margin (%)</label>
                                    <input type="number" id="profitMarginModal" class="form-control" min="0"
                                        step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profitAmountModal">Profit Amount</label>
                                    <input type="number" id="profitAmount" class="form-control" min="0"
                                        step="0.01" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modalFinalPrice">Final Price</label>
                                    <input type="number" id="modalFinalPrice" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveCalculation">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #price-collection-create-menu").addClass("active");
        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });
        var rfqItemCollection = [];
        var productCollection = [];
        var productSearch = $('#productSearch');
        var suppliers = @json($suppliers);
        var currencies = @json($currencies);

        // search product
        productSearch.on('input', function() {
            var search = $(this).val().trim();
            var regex = new RegExp(search, 'i');
            // if search is empty, clear search results
            if (search == '') {
                $('#productSearchResult').empty();
                return;
            }
            // Filter the productCollection based on the search term
            var result = productCollection.filter(product =>
                (product.name && product.name.match(regex)) ||
                (product.model && product.model.match(regex))
            );
            console.log(result);
            var html = '';
            result.slice(0, 10).forEach(function(product) {
                html += '<li class="list-group-item product-item" data-id="' + product.id +
                    '" data-name="' + product.name + '" data-rfq-item-id="' + product.rfq_item_id +
                    '" data-rfq-id="' + product.rfq_id + '">' +
                    product.name + '|' + product.model +
                    '</li>';
            });
            $('#productSearchResult').html(html);
        });

        // Handle product selection from search results
        $(document).on('click', '.product-item', function() {
            let productId = $(this).data('id');
            let productName = $(this).data('name');
            let rfqId = $(this).data('rfq-id');
            let rfqItemId = $(this).data('rfq-item-id');
            $('#productSearchResult').html(''); // Clear search results
            $('#productSearch').val(''); // Clear search input
            let row = '<tr>' +
                '<td>' + productName +
                '<input type="hidden" name="product_id[]" value="' + productId + '"/>' +
                '<input type="hidden" name="rfq_id[]" value="' + rfqId + '"/>' +
                '<input type="hidden" name="rfq_item_id[]" value="' + rfqItemId + '"/>' +
                '</td>' +
                '<td><select name="supplier_id[]" class="form-control selectpicker" required><option value="">Select Supplier</option>' +
                suppliers.map(supplier => '<option value="' + supplier.id + '">' + supplier.name + '</option>') +
                '</select></td>' +
                '<td><input type="text" name="note[]" class="form-control" /></td>' +
                '<td><input type="number" name="market_price[]" value="0" onchange="calculate()" class="form-control market_price" min="0" /></td>' +
                '<td><select name="currency_id[]" class="form-control selectpicker" onchange="calculate()"><option value="">Select Currency</option>' +
                currencies.map(currency => '<option value="' + currency.id + '">' + currency.name + '</option>') +
                '</select></td>' +
                '<td><input type="number" name="currency_rate[]" value="1" class="form-control currency_rate" onkeyup="calculate()" step="0.01" /></td>' +
                '<td><input type="number" name="shipping_weight[]" class="form-control shipping_weight" min="0" step="0.01" value="0" onkeyup="calculate()" /></td>' +
                '<td><input type="number" name="customs_unit_cost[]" class="form-control customs_unit_cost" min="0" step="0.01" value="0" onkeyup="calculate()" /></td>' +
                '<td><input type="number" name="customs_total_cost[]" class="form-control customs_total_cost" min="0" step="0.01" value="0" readonly /></td>' +
                '<td><input type="number" name="profit_margin_percentage[]" class="form-control profit_margin" min="0" step="0.01" value="1" /></td>' +
                '<td><input type="number" name="profit_margin_amount[]" class="form-control profit_amount" min="0" step="0.01" value="0" /></td>' +
                '<td><input type="number" name="tax_amount[]" class="form-control tax_amount" min="0" step="0.01" value="0" onkeyup="calculate()" /></td>' +
                '<td><input type="number" name="vat_amount[]" class="form-control vat_amount" min="0" step="0.01" value="0" onkeyup="calculate()" /></td>' +
                '<td><input type="number" name="other_cost[]" class="form-control other_cost" min="0" step="0.01" value="0" readonly /></td>' +
                '<td><input type="number" name="total_cost[]" class="form-control total_cost" min="0" step="0.01" value="0" readonly /></td>' +
                '<td><input type="text" name="origin[]" class="form-control" /></td>' +
                '<td><input type="number" name="delivery_days[]" class="form-control" min="0" step="1" value="0" /></td>' +

                '<td><button class="btn btn-warning calculate-row" data-toggle="modal" data-target="#calculationModal"><i class="fa fa-calculator"></i></button>' +
                '<button class="btn btn-danger remove-row"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
            // Append the new row to the table
            $('#myTable tbody').append(row);
            // selectpicker render for supplier select
            $('.selectpicker').selectpicker({
                style: 'btn-link',
            });
            calculate();
        });

        $(document).on('click', '.calculate-row', function() {
            let row = $(this).closest('tr');
            let totalCost = row.find('.total_cost').val();
            let profitMargin = row.find('.profit_margin').val();

            $('#modalTotalCost').val(totalCost);
            $('#modalProfitMargin').val(profitMargin);

            $('#modalProfitMargin').on('input', function() {
                let newProfitMargin = $(this).val();
                let finalPrice = (parseFloat(totalCost) * (1 + newProfitMargin / 100)).toFixed(2);
                $('#modalFinalPrice').val(finalPrice);
            });

            $('#saveCalculation').off('click').on('click', function() {
                let updatedProfitMargin = $('#modalProfitMargin').val();
                let updatedFinalPrice = $('#modalFinalPrice').val();

                row.find('.profit_margin').val(updatedProfitMargin);
                row.find('.total_cost').val(updatedFinalPrice);

                $('#calculationModal').modal('hide');
            });
        });


        // Remove product from the table
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        function calculate() {
            let total = 0;

            // Loop through each row in the table
            $('#myTable tbody tr').each(function() {
                let row = $(this); // Current row

                // Get values from the row and convert them to numbers
                let marketPrice = parseFloat(row.find('.market_price').val()) || 0;
                let profitAmount = parseFloat(row.find('.profit_amount').val()) || 0;
                let taxAmount = parseFloat(row.find('.tax_amount').val()) || 0;
                let vatAmount = parseFloat(row.find('.vat_amount').val()) || 0;
                let shippingWeight = parseFloat(row.find('.shipping_weight').val()) || 0;
                let customsUnitCost = parseFloat(row.find('.customs_unit_cost').val()) || 0;

                // Calculate customs total cost
                let customsTotalCost = shippingWeight * customsUnitCost;
                row.find('.customs_total_cost').val(customsTotalCost.toFixed(2));

                // Calculate other costs
                let otherCost = profitAmount + taxAmount + vatAmount + customsTotalCost;
                row.find('.other_cost').val(otherCost.toFixed(2));

                // Calculate total cost per row
                let totalCost = marketPrice + otherCost;
                row.find('.total_cost').val(totalCost.toFixed(2));

                // Accumulate total for all rows
                total += marketPrice;
            });

            // Set overall total value
            $('#total').val(total.toFixed(2));
        }

        function getRfq(e) {
            var rfq_id = $(e).val();
            if (rfq_id != '') {
                $.ajax({
                    url: "{{ route('price-collection.getRfqItems') }}",
                    type: 'POST',
                    data: {
                        rfq_id: rfq_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        rfqItemCollection = data?.items;
                        productCollection = data?.items.map(item => {
                            return {
                                id: item.product.id,
                                name: item.product.name,
                                rfq_item_id: item.id,
                                rfq_id: item.requested_quotation_id,
                                model: item.product.model,
                            };
                        });
                        // insert productResultUl list of productCollection
                        var html = '';
                        $.each(productCollection, function(key, value) {
                            html += '<li class="list-group-item product-item" data-id="' + value.id +
                                '" data-name="' + value.name + '" data-rfq-item-id="' + value
                                .rfq_item_id +
                                '" data-rfq-id="' + value.rfq_id + '">' +
                                value.name + '|' + value.model +
                                '</li>';
                        });
                        $('#productResultUl').html(html);
                        // table clear
                        $('#myTable tbody').html('');
                        console.log(productCollection);
                        console.log(rfqItemCollection);
                    }
                });
            } else {
                $('#productResultUl').html('');
                productCollection = [];
            }
        }
    </script>
@endpush
