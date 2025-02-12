@extends('backend.layout.main')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.Supplier Wise RFQ Show') }}</h3>
                </div>
                <div class="card-body">
                    
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
    </script>
@endpush
