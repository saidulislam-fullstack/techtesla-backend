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
                                                        <th>{{ trans('file.Market Price') }}</th>
                                                        <th>{{ trans('file.Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td>
                                                            <input type="text" id="total" class="form-control"
                                                                readonly />
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
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
            var result = productCollection.filter(product => product.name && product.name.match(regex));
            console.log(result);
            var html = '';
            result.slice(0, 10).forEach(function(product) {
                html += '<li class="list-group-item product-item" data-id="' + product.id +
                    '" data-name="' + product.name + '" data-rfq-item-id="' + product.rfq_item_id +
                    '" data-rfq-id="' + product.rfq_id + '">' +
                    product.name +
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
                '<td><input type="number" name="market_price[]" value="0" onchange="totalPrice()" class="form-control market_price" min="0" /></td>' +
                '<td><button class="btn btn-danger remove-row"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
            // Append the new row to the table
            $('#myTable tbody').append(row);
            // selectpicker render for supplier select
            $('.selectpicker').selectpicker({
                style: 'btn-link',
            });
            totalPrice();
        });

        // Remove product from the table
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        function totalPrice() {
            var total = 0;
            $('.market_price').each(function() {
                total += parseFloat($(this).val());
            });

            $('#total').val(total);
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
                            };
                        });
                        console.log(productCollection);
                        console.log(rfqItemCollection);
                    }
                });
            }
        }
    </script>
@endpush
