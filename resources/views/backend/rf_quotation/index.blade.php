@extends('backend.layout.main')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/yajra-laravel-datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/yajra-laravel-datatables/responsive.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/yajra-laravel-datatables/datatables.custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
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
@push('js')
    {{-- <script src="{{ asset('vendor/yajra-laravel-datatables/dataTables.responsive.min.js') }}"></script> --}}
    <script src="{{ asset('vendor/yajra-laravel-datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="text/javascript">
        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #rf-quotation-list-menu").addClass("active");
        var table = $('#rf-quotation-table');

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "rf-quotation/" + id,
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token,
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    text: data.success,
                                    icon: "success",
                                }).then((result) => {
                                    table.DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    text: data.error,
                                    icon: "error",
                                }).then((result) => {
                                    table.DataTable().ajax.reload();
                                });
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        text: "Your data is safe!",
                        icon: "info",
                    });
                }
            });
        }
    </script>
@endpush
