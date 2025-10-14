@extends('backend.layout.main') @section('content')
@if(session()->has('not_permitted'))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
        aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Add Supplier')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input
                                fields')}}.</small></p>
                        {!! Form::open(['route' => 'supplier.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-4 mt-4 d-none">
                                <div class="form-group">
                                    <input type="checkbox" name="both" value="1" />&nbsp;
                                    <label>{{trans('file.Both Customer and Supplier')}}</label>
                                </div>
                            </div>
                            <div class="col-md-4 customer-group-section">
                                <div class="form-group">
                                    <label>{{trans('file.Customer Group')}} *</strong> </label>
                                    <select class="form-control selectpicker" id="customer-group-id"
                                        name="customer_group_id">
                                        @foreach($lims_customer_group_all as $customer_group)
                                        <option value="{{$customer_group->id}}">{{$customer_group->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.name')}} </strong> </label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Image')}}</label>
                                    <input type="file" name="image" class="form-control">
                                    @if($errors->has('image'))
                                    <span>
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Company Name')}} *</label>
                                    <input type="text" name="company_name" required class="form-control">
                                    @if($errors->has('company_name'))
                                    <span>
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Supplier Category *</strong> </label>
                                    <select class="form-control" id="" name="supplier_type" required>
                                        <option value="">--</option>
                                        <option value="local">Local</option>
                                        <option value="foreign">Foreign</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Company Specialization *</label>
                                    <input type="text" name="company_specialization" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Products & Services *</label>
                                    <input type="text" name="products_and_services" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bussiness Type *</label>
                                    <select class="form-control" id="" name="distributionship_or_agency" required>
                                        <option value="">--</option>
                                        <option value="distributionship">Distributionship</option>
                                        <option value="agency">Agency</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.VAT Number')}}</label>
                                    <input type="text" name="vat_number" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Email')}} *</label>
                                    <input type="email" name="email" placeholder="example@example.com" required
                                        class="form-control">
                                    @if($errors->has('email'))
                                    <span>
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Phone Number')}} </label>
                                    <input type="text" name="phone_number" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Address')}} *</label>
                                    <input type="text" name="address" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.City')}}</label>
                                    <input type="text" name="city" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.State')}}</label>
                                    <input type="text" name="state" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Postal Code')}}</label>
                                    <input type="text" name="postal_code" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Country')}}</label>
                                    <input type="text" name="country" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row my-4">
                                    <div class="col-md-12">
                                        <h5>Contact Person Details:</h5>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" name="contact_person_name" class="form-control" required>
                                            @if($errors->has('contact_person_name'))
                                            <span>
                                                <strong>{{ $errors->first('contact_person_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Email *</label>
                                            <input type="text" name="contact_person_email" class="form-control"
                                                required>
                                            @if($errors->has('contact_person_email'))
                                            <span>
                                                <strong>{{ $errors->first('contact_person_email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Phone Number *</label>
                                            <input type="text" name="contact_person_phone_number" class="form-control"
                                                required>
                                            @if($errors->has('contact_person_phone_number'))
                                            <span>
                                                <strong>{{ $errors->first('contact_person_phone_number') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Designation *</label>
                                            <input type="text" name="contact_person_designation" class="form-control"
                                                required>
                                            @if($errors->has('contact_person_designation'))
                                            <span>
                                                <strong>{{ $errors->first('contact_person_designation') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Visiting Card Front </label>
                                            <input type="file" name="visiting_card_front" class="form-control">
                                            @if($errors->has('visiting_card_front'))
                                            <span>
                                                <strong>{{ $errors->first('visiting_card_front') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Visiting Card Back </label>
                                            <input type="file" name="visiting_card_back" class="form-control">
                                            @if($errors->has('visiting_card_back'))
                                            <span>
                                                <strong>{{ $errors->first('visiting_card_back') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mt-4">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $("ul#people #supplier-create-menu").addClass("active");
    $(".customer-group-section").hide();

    $('input[name="both"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('.customer-group-section').show(300);
            $('select[name="customer_group_id"]').prop('required',true);
        }
        else{
            $('.customer-group-section').hide(300);
            $('select[name="customer_group_id"]').prop('required',false);
        }
    });
</script>
@endpush