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
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{!! session()->get('error') !!}
        </div>
    @endif
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title">{{ trans('file.RFQ Report') }}</h3>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="button" data-toggle="collapse"
                                data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-filter"></i> {{ trans('file.Filter') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_range" class="form-label">{{ trans('file.Date') }}</label>
                                    <input type="text" name="date_range" id="date_range" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <button type="button" onclick="search()" class="btn btn-primary btn-block"
                                        id="search">
                                        <i class="fa fa-search" aria-hidden="true"></i> {{ trans('file.Search') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <button type="button" onclick="reset()" class="btn btn-danger btn-block"
                                        id="reset">
                                        <i class="fa fa-refresh" aria-hidden="true"></i> {{ trans('file.Reset') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        var table = $('#rf-quotation-report-table');
        $("ul#quotation").siblings('a').attr('aria-expanded', 'true');
        $("ul#quotation").addClass("show");
        $("ul#quotation #rf-quotation-report-menu").addClass("active");
        $('#date_range').daterangepicker({
            callback: function(startDate, endDate, period) {
                var starting_date = startDate.format('YYYY-MM-DD');
                var ending_date = endDate.format('YYYY-MM-DD');
                var title = starting_date + ' To ' + ending_date;
                $(this).val(title);
            }
        });

        function search() {
            var date_range = $('#date_range').val();
            table.on('preXhr.dt', function(e, settings, data) {
                data.date_range = date_range;
            });
            table.DataTable().ajax.reload();
        }

        function reset() {
            $('#date_range').val('');
            table.on('preXhr.dt', function(e, settings, data) {
                data.date_range = '';
            });
            table.DataTable().ajax.reload();
        }
    </script>
@endpush
