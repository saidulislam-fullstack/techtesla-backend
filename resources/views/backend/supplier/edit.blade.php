@extends('backend.layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Update Supplier')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => ['supplier.update', $lims_supplier_data->id], 'method' => 'put', 'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.name')}} / {{trans('file.Company Name')}} *</strong> </label>
                                    <input type="text" name="name" value="{{$lims_supplier_data->name}}" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6 d-none">
                                <div class="form-group">
                                    <label>{{trans('file.Company Name')}} *</label>
                                    <input type="text" name="company_name" value="{{$lims_supplier_data->company_name}}" class="form-control">
                                    @if($errors->has('company_name'))
                                   <span>
                                       <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Supplier Category *</label>
                                    <select class="form-control" name="supplier_type" required>
                                        <option value="">--</option>
                                        <option value="local" {{ $lims_supplier_data->supplier_type == 'local' ? 'selected' : '' }}>Local</option>
                                        <option value="foreign" {{ $lims_supplier_data->supplier_type == 'foreign' ? 'selected' : '' }}>Foreign</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Specialization *</label>
                                    <input type="text" name="company_specialization" required class="form-control"
                                        value="{{ $lims_supplier_data->company_specialization }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Products & Services *</label>
                                    <input type="text" name="products_and_services" required class="form-control"
                                        value="{{ $lims_supplier_data->products_and_services }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Business Type *</label>
                                    <select class="form-control" name="distributionship_or_agency" required>
                                        <option value="">--</option>
                                        <option value="distributionship" 
                                            {{ $lims_supplier_data->distributionship_or_agency == 'distributionship' ? 'selected' : '' }}>
                                            Distributionship
                                        </option>
                                        <option value="agency" 
                                            {{ $lims_supplier_data->distributionship_or_agency == 'agency' ? 'selected' : '' }}>
                                            Agency
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.VAT Number')}}</label>
                                    <input type="text" name="vat_number" value="{{$lims_supplier_data->vat_number}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Email')}} *</label>
                                    <input type="email" name="email" value="{{$lims_supplier_data->email}}" required class="form-control">
                                    @if($errors->has('email'))
                                   <span>
                                       <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Phone Number')}} </label>
                                    <input type="text" name="phone_number" value="{{$lims_supplier_data->phone_number}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Address')}} *</label>
                                    <input type="text" name="address" value="{{$lims_supplier_data->address}}" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.City')}} </label>
                                    <input type="text" name="city"  value="{{$lims_supplier_data->city}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.State')}}</label>
                                    <input type="text" name="state" value="{{$lims_supplier_data->state}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Postal Code')}}</label>
                                    <input type="text" name="postal_code" value="{{$lims_supplier_data->postal_code}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Country')}}</label>
                                    <input type="text" name="country" value="{{$lims_supplier_data->country}}" class="form-control">
                                </div>
                            </div>




                            <hr>

                            <div class="col-12 d-flex justify-content-between align-items-center mt-5 mb-2">
                                <h5>Contact Person Details:</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addContactPerson">+ Add More</button>
                            </div>

                            <div class="col-12" id="contactPersonWrapper">

                                @foreach($lims_supplier_data->contactPersons as $i => $cp)
                                <div class="contact-person-item row mb-4">

                                    <input type="hidden" name="contact_persons[{{$i}}][id]" value="{{$cp->id}}">

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" name="contact_persons[{{$i}}][name]" class="form-control"
                                                value="{{$cp->name}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Email *</label>
                                            <input type="email" name="contact_persons[{{$i}}][email]"
                                                class="form-control" value="{{$cp->email}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Phone Number *</label>
                                            <input type="text" name="contact_persons[{{$i}}][phone]"
                                                class="form-control" value="{{$cp->phone}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Designation *</label>
                                            <input type="text" name="contact_persons[{{$i}}][designation]"
                                                class="form-control" value="{{$cp->designation}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Visiting Card Front</label><br>
                                            @if($cp->visiting_card_front)
                                            <img src="{{ asset('uploads/visiting_cards/'.$cp->visiting_card_front) }}"
                                                width="80">
                                            @endif
                                            <input type="file" name="contact_persons[{{$i}}][visiting_card_front]"
                                                class="form-control mt-2">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Visiting Card Back</label><br>
                                            @if($cp->visiting_card_back)
                                            <img src="{{ asset('uploads/visiting_cards/'.$cp->visiting_card_back) }}"
                                                width="80">
                                            @endif
                                            <input type="file" name="contact_persons[{{$i}}][visiting_card_back]"
                                                class="form-control mt-2">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <button type="button"
                                            class="btn btn-danger btn-sm removeContactBtn">Remove</button>
                                    </div>

                                </div>
                                @endforeach

                            </div>

                            <!-- Template for adding new rows -->
                            <template id="contactPersonTemplate">
                                <div class="contact-person-item row mb-4">

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" name="contact_persons[INDEX][name]" class="form-control"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Email *</label>
                                            <input type="email" name="contact_persons[INDEX][email]"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Phone Number *</label>
                                            <input type="text" name="contact_persons[INDEX][phone]" class="form-control"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Designation *</label>
                                            <input type="text" name="contact_persons[INDEX][designation]"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Visiting Card Front</label>
                                            <input type="file" name="contact_persons[INDEX][visiting_card_front]"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Visiting Card Back</label>
                                            <input type="file" name="contact_persons[INDEX][visiting_card_back]"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <button type="button"
                                            class="btn btn-danger btn-sm removeContactBtn">Remove</button>
                                    </div>
                                </div>
                            </template>





                            <div class="col-md-12">
                                <div class="form-group mt-3">
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


    let index = {{ count($lims_supplier_data->contactPersons) }};

    document.getElementById('addContactPerson').addEventListener('click', function () {
        let template = document.getElementById('contactPersonTemplate').innerHTML;
        template = template.replace(/INDEX/g, index);
        document.getElementById('contactPersonWrapper').insertAdjacentHTML('beforeend', template);
        index++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeContactBtn')) {
            e.target.closest('.contact-person-item').remove();
        }
    });
</script>
@endpush
