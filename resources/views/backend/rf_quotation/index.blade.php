@extends('backend.layout.main')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/yajra-laravel-datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/yajra-laravel-datatables/responsive.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/yajra-laravel-datatables/datatables.custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data-table.css') }}">
@endpush
@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
        </div>
    @endif
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{ trans('file.Requested Quotation List') }}</h3>
                </div>
            </div>
            @can('rf-quotes-add')
                <a href="{{ route('rf-quotation.create') }}" class="btn btn-info"><i class="dripicons-plus"></i>
                    {{ trans('file.Add RFQuotation') }}</a>&nbsp;
            @endcan
            {{ $dataTable->table() }}
        </div>
    </section>
@endsection
@push('scripts')
    {{-- <script src="{{ asset('vendor/yajra-laravel-datatables/dataTables.responsive.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/yajra-laravel-datatables/datatables.min.js') }}"></script> --}}
@endpush
@push('js')
    <script>
        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #rf-quotation-list-menu").addClass("active");
    </script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
