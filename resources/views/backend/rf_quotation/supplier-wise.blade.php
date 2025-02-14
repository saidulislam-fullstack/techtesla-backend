@extends('backend.layout.main')
@section('content')
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
                                <select name="supplier_id" id="supplier_id" class="form-control selectpicker" required>
                                    <option value="">{{ trans('file.Select Supplier') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('scripts')
    <script>
        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #rf-quotation-supplier-wise-menu").addClass("active");
        const rFQs = @json($rfQs);

        function selectRFQ(e) {
            let rfq_id = $(e).val();
            console.log(rfq_id);
            let supplier_id = $('#supplier_id');
            supplier_id.empty();
            let rFQ = rFQs.find(rfq => rfq.id == rfq_id);
            console.log(rFQ);
            if (rFQ) {
                let suppliers = rFQ.price_collection
                    .filter(item => item.is_selected == 1)
                    .map(item => item.supplier)
                    .filter((value, index, self) => self.findIndex(s => s.id === value.id) === index);

                console.log(suppliers);
                if (suppliers.length > 0) {
                    suppliers.forEach(supplier => {
                        supplier_id.append(`<option value="${supplier.id}">${supplier.name}</option>`);
                    });
                }
            }
        }
    </script>
@endpush
