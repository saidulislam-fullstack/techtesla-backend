@extends('backend.layout.main')
@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('error') !!}
        </div>
    @endif
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.Supplier Wise RFQ Show') }}</h3>
                </div>
                <div class="card-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    <form method="POST" action="{{ route('rf-quotation.supplier-wise-purchase') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rfq_id">{{ trans('file.RFQ') }}:</label><span class="required">
                                        *</span>
                                    <select name="rfq_id" id="rfq_id" class="form-control selectpicker"
                                        onchange="selectRFQ(this)" required>
                                        <option value="">{{ trans('file.Select RFQ') }}</option>
                                        @foreach ($rfQs as $item)
                                            <option value="{{ $item->id }}">{{ $item->rfq_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier_id">{{ trans('file.Supplier') }}</label><span class="required">
                                        *</span>
                                    <select name="supplier_id" id="supplier_id" class="form-control selectpicker"
                                        onchange="selectSuppler(this)" required>
                                        <option value="">{{ trans('file.Select Supplier') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="supplier-wise-table">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('file.Product') }}</th>
                                            <th>{{ trans('file.Code') }}</th>
                                            <th>{{ trans('file.Quantity') }}</th>
                                            <th>{{ trans('file.Unit Price') }}</th>
                                            <th>{{ trans('file.Sub Total') }}</th>
                                            <th>{{ trans('file.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="supplier-wise-tbody">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right">
                                                <strong>{{ trans('file.Total Item') }}</strong>
                                            </td>
                                            <td>
                                                <strong id="total_item_text">0</strong>
                                                <input type="hidden" name="total_item" id="total_item" value="0">
                                            </td>
                                            <td class="text-right">
                                                <strong>
                                                    {{ trans('file.Total Quantity') }}
                                                </strong>
                                            </td>
                                            <td>
                                                <strong id="total_quantity_text">0</strong>
                                                <input type="hidden" name="total_quantity" id="total_quantity"
                                                    value="0">
                                            </td>
                                            <td class="text-right">
                                                <strong>
                                                    {{ trans('file.Grand Total') }}
                                                </strong>
                                            </td>
                                            <td>
                                                <strong id="grand_total_text">0</strong>
                                                <input type="hidden" name="grand_total" id="grand_total" value="0">
                                            </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary d-none" id="submit-button">
                                        {{ trans('file.Submit') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection
@push('scripts')
    <script>
        $('.selectpicker').selectpicker();
        $("ul#price-collection").siblings('a').attr('aria-expanded', 'true');
        $("ul#price-collection").addClass("show");
        $("ul#price-collection #rf-quotation-supplier-wise-menu").addClass("active");
        const rFQs = @json($rfQs);

        function selectRFQ(e) {
            let rfq_id = $(e).val();
            let supplier_id = $('#supplier_id');
            supplier_id.empty();
            let rFQ = rFQs.find(rfq => rfq.id == rfq_id);
            if (rFQ) {
                let suppliers = rFQ.price_collection
                    .filter(item => {
                        return item.is_selected == 1;
                    })
                    .map(item => {
                        return item.supplier;
                    })
                    .filter((value, index, self) => {
                        return self.findIndex(s => s.id === value.id) === index;
                    });

                if (suppliers.length > 0) {
                    supplier_id.append(`<option value="">Select Supplier</option>`);
                    suppliers.forEach(supplier => {
                        supplier_id.append(`<option value="${supplier.id}">${supplier.name}</option>`);
                    });
                    supplier_id.selectpicker('refresh');
                    supplier_id.trigger("change");
                }
            }
        }

        function selectSuppler(e) {
            let supplier_id = $(e).val();
            let rfq_id = $('#rfq_id').val();
            let supplier_wise_tbody = $('#supplier-wise-tbody');
            supplier_wise_tbody.empty();
            if (rfq_id && supplier_id) {
                let rFQ = rFQs.find(rfq => rfq.id == rfq_id);
                if (rFQ) {
                    let supplierItems = rFQ.price_collection
                        .filter(item => item.supplier_id == supplier_id && item.is_selected == 1);

                    if (supplierItems.length > 0) {
                        supplierItems.forEach(item => {
                            let row = `
                                <tr>
                                    <td>
                                        ${item.product.name}
                                        <input type="hidden" name="items[product_id][]" value="${item.product_id}">
                                    </td>
                                    <td>
                                        ${item.product.code}
                                        <input type="hidden" name="items[unit_id][]" value="${item.product.unit_id}">
                                        <input type="hidden" name="items[rfq_item_id][]" value="${item.rfq_item_id}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control quantity" onkeyup="calculate()" name="items[quantity][]" value="1" min='1' required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control unit_price" onkeyup="calculate()" name="items[unit_price][]" value="${item.price}" required>
                                        </td>
                                    <td class="sub_total">0</td>
                                    <td>
                                        <a href="#" onclick="deleteRow(this)"
                                            class="btn btn-danger btn-sm" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            `;
                            supplier_wise_tbody.append(row); // Append the row to the table body
                        });
                        calculate();
                        $("#submit-button").removeClass('d-none');
                    } else {
                        supplier_wise_tbody.append(`<tr><td colspan="5" class="text-center">No Data Found</td></tr>`);
                    }
                }
            } else {
                supplier_wise_tbody.append(
                    `<tr><td colspan="6" class="text-center">Please select an RFQ and a supplier.</td></tr>`);
            }
        }

        function deleteRow(e) {
            $(e).closest('tr').remove();
            calculate();
        }

        function calculate() {
            let supplier_wise_tbody = $('#supplier-wise-tbody');
            let sub_total = 0;
            let total_quantity = 0;
            let total_item = 0;
            supplier_wise_tbody.find('tr').each(function() {
                let row = $(this);
                let quantity = row.find('.quantity').val() || 1;
                let unit_price = row.find('.unit_price').val() || 0;
                let sub_total_td = row.find('.sub_total') || 0;
                let sub_total = quantity * unit_price;
                sub_total_td.text(sub_total.toFixed(2));
                total_quantity += parseInt(quantity);
                total_item++;
            });
            let total = supplier_wise_tbody.find('tr').length > 0 ? supplier_wise_tbody.find('tr').map(function() {
                return parseFloat($(this).find('.sub_total').text());
            }).get().reduce((a, b) => a + b) : 0;
            $('#total_item_text').text(total_item);
            $('#total_item').val(total_item);
            $('#total_quantity_text').text(total_quantity);
            $('#total_quantity').val(total_quantity);
            $('#grand_total_text').text(total.toFixed(2));
            $('#grand_total').val(total.toFixed(2));
        }
    </script>
@endpush
