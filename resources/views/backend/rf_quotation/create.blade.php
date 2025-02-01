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
                                            <label>{{ trans('file.Warehouse') }} *</label>
                                            <select id="warehouse_id" name="warehouse_id" required
                                                class="selectpicker form-control" data-live-search="true"
                                                title="Select warehouse...">
                                                @foreach ($warehouse_list as $warehouse)
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label>{{ trans('file.Select Product') }}</label>
                                        <div class="search-box input-group">
                                            <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_name" id="productSearch"
                                                placeholder="Please type product code and select..." class="form-control" />
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
        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #rf-quotation-create-menu").addClass("active");

        var product_array = [];
        var product_code = [];
        var product_name = [];
        var product_qty = [];
        var product_type = [];
        var product_id = [];
        var product_list = [];
        var qty_list = [];
        var product_warehouse_price = [];


        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });

        $('select[name="warehouse_id"]').on('change', function() {
            var id = $(this).val();
            $.get('getproduct/' + id, function(data) {
                product_array = [];
                product_code = data[0];
                product_name = data[1];
                product_qty = data[2];
                product_type = data[3];
                product_id = data[4];
                product_list = data[5];
                qty_list = data[6];
                product_warehouse_price = data[7];
                $.each(product_code, function(index) {
                    product_array.push(product_code[index] + ' (' + product_name[index] + ')');
                });
            });
        });

        $('#productSearch').on('input', function() {
            var customer_id = $('#customer_id').val();
            var warehouse_id = $('#warehouse_id').val();
            temp_data = $('#productSearch').val();
            if (!customer_id) {
                $('#productSearch').val(temp_data.substring(0, temp_data.length - 1));
                alert('Please select Customer!');
            } else if (!warehouse_id) {
                $('#productSearch').val(temp_data.substring(0, temp_data.length - 1));
                alert('Please select Warehouse!');
            }
        });

        var productSearch = $('#productSearch');

        productSearch.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(product_array, function(item) {
                    return matcher.test(item);
                }));
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    var data = ui.content[0].value;
                    console.log(data);

                    $(this).autocomplete("close");
                    productSearch(data);
                };
            },
            select: function(event, ui) {
                var data = ui.item.value;
                productSearch(data);
            }
        });


        function productSearch(data) {
            $.ajax({
                type: 'GET',
                url: 'lims_product_search',
                data: {
                    data: data
                },
                success: function(data) {
                    console.log(data);

                }
            });
        }
    </script>
@endpush
