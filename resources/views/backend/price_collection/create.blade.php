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
                        <form method="post" action="{{ route('price-collection.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rfq_id">{{ trans('file.RFQ') }}</label><span class="required">
                                            *</span>
                                        <select name="rfq_id" id="rfq_id" class="form-control selectpicker"
                                            data-live-search="true" onchange="getRfq(this)" required>
                                            <option value="">{{ trans('file.Select RFQ') }}</option>
                                            @foreach ($rfqs as $item)
                                            <option value="{{ $item->id }}" @selected(request()->rfq_id == $item->id)>
                                                {{ $item->rfq_no }}
                                            </option>
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
                                            placeholder="Please type product model and select..."
                                            class="form-control" />
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
                                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary"
                                            id="submit-button" />
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
                        <input type="hidden" id="marketPriceModal" value="0">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="#currencyModal">{{ trans('file.Currency') }}</label>
                                <select id="currencyModal" class="form-control" data-live-search="true">
                                    <option value="">{{ trans('file.Select Currency') }}</option>
                                    @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}" data-rate={{$currency->exchange_rate}}>{{
                                        $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currencyRateModal">{{ trans('file.Currency Rate') }}</label>
                                <input type="number" id="currencyRateModal" class="form-control changeModal" step="0.01"
                                    value="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shippingWeightModal">{{ trans('file.Shipping Weight') }}</label>
                                <input type="number" id="shippingWeightModal" class="form-control changeModal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customsUnitCostModal">{{ trans('file.Customs Unit Cost') }}</label>
                                <input type="number" id="customsUnitCostModal" class="form-control changeModal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profitPercentageModal">{{ trans('file.Profit Percentage') }}(%)</label>
                                <input type="number" id="profitPercentageModal" class="form-control changeModal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profitAmountModal">{{ trans('file.Profit Amount') }}</label>
                                <input type="number" id="profitAmountModal" class="form-control changeModal" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="taxAmountModal">{{ trans('file.Tax Amount') }}</label>
                                <input type="number" id="taxAmountModal" class="form-control changeModal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vatAmountModal">{{ trans('file.Vat Amount') }}</label>
                                <input type="number" id="vatAmountModal" class="form-control changeModal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="otherCostModal">{{ trans('file.Other Cost') }}</label>
                                <input type="number" id="otherCostModal" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="totalCostModal">{{ trans('file.Total Cost') }}</label>
                                <input type="number" id="totalCostModal" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="recommendedOriginModal">{{ trans('file.Recommended Origin') }}</label>
                                <input type="text" id="recommendedOriginModal" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deliveryDaysModal">{{ trans('file.Delivery Days') }}</label>
                                <input type="number" id="deliveryDaysModal" class="form-control">
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
    $("ul#price-collection").siblings('a').attr('aria-expanded', 'true');
        $("ul#price-collection").addClass("show");
        $("ul#price-collection #price-collection-create-menu").addClass("active");
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
                    product.name + ' | ' + product.model +
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

                '<input type="hidden" name="currency_id[]" value="" class="form-control currency_id" />' +
                '<input type="hidden" name="currency_rate[]" value="1" class="form-control currency_rate" step="0.01" />' +
                '<input type="hidden" name="shipping_weight[]" class="form-control shipping_weight" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="customs_unit_cost[]" class="form-control customs_unit_cost" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="customs_total_cost[]" class="form-control customs_total_cost" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="profit_margin_percentage[]" class="form-control profit_margin" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="profit_margin_amount[]" class="form-control profit_amount" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="tax_amount[]" class="form-control tax_amount" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="vat_amount[]" class="form-control vat_amount" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="other_cost[]" class="form-control other_cost" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="total_cost[]" class="form-control total_cost" min="0" step="0.01" value="0" />' +
                '<input type="hidden" name="origin[]" class="form-control origin" value="" />' +
                '<input type="hidden" name="delivery_days[]" class="form-control delivery_days" min="0" step="1" value="0" />' +
                '</td>' +

                '<td><select name="supplier_id[]" class="form-control" required><option value="">Select Supplier</option>' +
                suppliers.map(supplier => '<option value="' + supplier.id + '">' + supplier.name + '</option>') +
                '</select></td>' +
                '<td><input type="text" name="note[]" class="form-control" /></td>' +
                '<td><input type="number" name="market_price[]" value="0" onchange="calculate()" class="form-control market_price" min="0" /></td>' +
                '<td><button type="button" class="btn btn-warning calculate-row" data-toggle="modal" data-target="#calculationModal"><i class="fa fa-calculator"></i></button>' +
                '<button type="button" class="btn btn-danger remove-row"><i class="fa fa-trash"></i></button></td>' +
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
            resetModal();
            let row = $(this).closest('tr');

            let marketPrice = row.find('.market_price').val() || 0,
                currencyId = row.find('.currency_id').val() || '',
                currencyRate = row.find('.currency_rate').val() || 1,
                shippingWeight = row.find('.shipping_weight').val() || 0,
                customsUnitCost = row.find('.customs_unit_cost').val() || 0,
                profitMargin = row.find('.profit_margin').val() || 0,
                profitAmount = row.find('.profit_amount').val() || 0,
                taxAmount = row.find('.tax_amount').val() || 0,
                vatAmount = row.find('.vat_amount').val() || 0,
                otherCost = row.find('.other_cost').val() || 0,
                totalCost = row.find('.total_cost').val() || 0,
                origin = row.find('.origin').val() || '',
                deliveryDays = row.find('.delivery_days').val() || 0;

            $('#marketPriceModal').val(marketPrice);
            $('#currencyModal').val(currencyId).trigger('change');
            $('#currencyRateModal').val(currencyRate);
            $('#shippingWeightModal').val(shippingWeight);
            $('#customsUnitCostModal').val(customsUnitCost);
            $('#profitPercentageModal').val(profitMargin);
            $('#profitAmountModal').val(profitAmount);
            $('#taxAmountModal').val(taxAmount);
            $('#vatAmountModal').val(vatAmount);
            $('#otherCostModal').val(otherCost);
            $('#totalCostModal').val(totalCost);
            $('#recommendedOriginModal').val(origin);
            $('#deliveryDaysModal').val(deliveryDays);

            $('.changeModal').on('input', function() {
                let exchangeRate = $('#currencyRateModal').val() || 1;
                let profitPercentage = $('#profitPercentageModal').val();
                let vatAmount = parseFloat($('#vatAmountModal').val()) || 0;
                let taxAmount = parseFloat($('#taxAmountModal').val()) || 0;
                let shippingWeight = $('#shippingWeightModal').val() || 0;
                let customsUnitCost = $('#customsUnitCostModal').val() || 0;
                // let profitAmount = (((marketPrice * exchangeRate) + vatAmount + taxAmount + customsTotalCost) * profitPercentage) / 100;
                // $('#profitAmountModal').val(profitAmount.toFixed(2));
                let customsTotalCost = shippingWeight * customsUnitCost;
                $('#customsTotalCostModal').val(customsTotalCost.toFixed(2));
                let profitAmount = (((marketPrice * exchangeRate) + vatAmount + taxAmount + customsTotalCost) * profitPercentage) / 100;
                $('#profitAmountModal').val(profitAmount.toFixed(2));
                let otherCost = profitAmount + vatAmount + taxAmount + customsTotalCost;
                $('#otherCostModal').val(otherCost.toFixed(2));
                let totalCost = (parseFloat(marketPrice * exchangeRate) + otherCost) ;
                $('#totalCostModal').val(totalCost.toFixed(2));
            });

            $('#saveCalculation').on('click', function() {
                row.find('.currency_id').val($('#currencyModal').val());
                row.find('.currency_rate').val($('#currencyRateModal').val());
                row.find('.shipping_weight').val($('#shippingWeightModal').val());
                row.find('.customs_unit_cost').val($('#customsUnitCostModal').val());
                row.find('.profit_margin').val($('#profitPercentageModal').val());
                row.find('.profit_amount').val($('#profitAmountModal').val());
                row.find('.tax_amount').val($('#taxAmountModal').val());
                row.find('.vat_amount').val($('#vatAmountModal').val());
                row.find('.other_cost').val($('#otherCostModal').val());
                row.find('.total_cost').val($('#totalCostModal').val());
                row.find('.origin').val($('#recommendedOriginModal').val());
                row.find('.delivery_days').val($('#deliveryDaysModal').val());

                $('#calculationModal').modal('hide');
                calculate();
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
                let profitPercentage = parseFloat(row.find('.profit_margin').val()) || 0;
                let profitAmount = parseFloat((marketPrice * profitPercentage) / 100) || 0;
                row.find('.profit_amount').val(profitAmount.toFixed(2));
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

        // Function to reset modal values
        function resetModal() {
            // Reset the values of all modal fields (to ensure no old values remain)
            $('#currencyModal').val('').trigger('change');
            $('#currencyRateModal').val('');
            $('#shippingWeightModal').val('');
            $('#customsUnitCostModal').val('');
            $('#profitPercentageModal').val('');
            $('#profitAmountModal').val('');
            $('#taxAmountModal').val('');
            $('#vatAmountModal').val('');
            $('#otherCostModal').val('');
            $('#totalCostModal').val('');
            $('#recommendedOriginModal').val('');
            $('#deliveryDaysModal').val('');

            // Trigger change events for proper recalculation
            $('#currencyModal').trigger('change');
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

        // When currency option changes in modal
        $(document).on('change', '#currencyModal', function () {
            let rate = $(this).find(':selected').data('rate') || 1;
            $('#currencyRateModal').val(rate);

            // trigger recalculation using existing handler
            $('.changeModal').trigger('input');
        });

</script>
@endpush