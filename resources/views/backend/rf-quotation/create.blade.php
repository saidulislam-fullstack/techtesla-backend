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
    </script>
@endpush
