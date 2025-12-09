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
<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
        aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
        aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('error') !!}
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
<div class="modal fade" id="othersInfoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form id="othersInfoForm">
                @csrf
                <input type="hidden" name="id" id="quotation_id">

                <div class="modal-header">
                    <h5 class="modal-title">Update Others Info</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4 mt-3">
                            <label>VAT Percentage</label>
                            <input type="text" name="vat_percentage" id="vat_percentage" class="form-control">
                        </div>

                        <div class="col-md-4 mt-3 d-none">
                            <label>VAT Amount</label>
                            <input type="text" name="vat_amount" id="vat_amount" class="form-control">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Payment Term</label>
                            <input type="text" name="payment_term" id="payment_term" class="form-control">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Price Validity</label>
                            <input type="text" name="price_validity" id="price_validity" class="form-control">
                        </div>

                        <div class="col-md-12 mt-3">
                            <label>Warranty</label>
                            <input type="text" name="warranty" id="warranty" class="form-control">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Suspension of Installation</label>
                            <input type="text" name="suspension_of_installation" id="suspension_of_installation"
                                class="form-control">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Commissioning</label>
                            <input type="text" name="commissioning" id="commissioning" class="form-control">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Mechanical Works</label>
                            <input type="text" name="mechanical_works" id="mechanical_works" class="form-control">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Cable Laying</label>
                            <input type="text" name="cable_laying" id="cable_laying" class="form-control">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>VAT</label>
                            <input type="text" name="vat" id="vat" class="form-control">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Tax</label>
                            <input type="text" name="tax" id="tax" class="form-control">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Transport</label>
                            <input type="text" name="transport" id="transport" class="form-control">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
@push('js')
{{-- <script src="{{ asset('vendor/yajra-laravel-datatables/dataTables.responsive.min.js') }}"></script> --}}
<script src="{{ asset('vendor/yajra-laravel-datatables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script type="text/javascript">
    function openOthersInfoModal(id) {
        $('#quotation_id').val(id);

        $.get('/rf-quotation/get-others-data/' + id, function(response) {

            // Auto-fill data if exists
            $('#vat_percentage').val(response.vat_percentage ?? '');
            $('#vat_amount').val(response.vat_amount ?? '');
            $('#payment_term').val(response.payment_term ?? '');
            $('#price_validity').val(response.price_validity ?? '');
            $('#warranty').val(response.warranty ?? '');
            $('#suspension_of_installation').val(response.suspension_of_installation ?? '');
            $('#commissioning').val(response.commissioning ?? '');
            $('#mechanical_works').val(response.mechanical_works ?? '');
            $('#cable_laying').val(response.cable_laying ?? '');
            $('#vat').val(response.vat ?? '');
            $('#tax').val(response.tax ?? '');
            $('#transport').val(response.transport ?? '');

            $('#othersInfoModal').modal('show');
        });
    }

    $('#othersInfoForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: "/rf-quotation/others-data-update",
            data: $(this).serialize(),
            success: function(res) {

                $('#othersInfoModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Others Info Updated Successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#purchase-table').DataTable().ajax.reload();
            },
            error: function(xhr) {

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please check your input fields!',
                });

                console.log(xhr.responseText);
            }
        });
    });

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