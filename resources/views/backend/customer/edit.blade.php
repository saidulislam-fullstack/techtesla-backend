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
                        <h4>{{trans('file.Update Customer')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input
                                fields')}}.</small></p>
                        {!! Form::open(['route' => ['customer.update',$lims_customer_data->id], 'method' => 'put',
                        'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="customer_group"
                                        value="{{$lims_customer_data->customer_group_id}}">
                                    <label>{{trans('file.Customer Group')}} *</strong> </label>
                                    <select required class="form-control selectpicker" name="customer_group_id">
                                        @foreach($lims_customer_group_all as $customer_group)
                                        <option value="{{$customer_group->id}}">{{$customer_group->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.name')}} / {{trans('file.Company Name')}} *</strong> </label>
                                    <input type="text" name="customer_name" value="{{$lims_customer_data->name}}"
                                        required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 d-none">
                                <div class="form-group">
                                    <label>{{trans('file.Company Name')}} </label>
                                    <input type="text" name="company_name" value="{{$lims_customer_data->company_name}}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Email')}}</label>
                                    <input type="email" name="email" value="{{$lims_customer_data->email}}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Phone Number')}} </label>
                                    <input type="text" name="phone_number" 
                                        value="{{$lims_customer_data->phone_number}}" class="form-control">
                                    @if($errors->has('phone_number'))
                                    <span>
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Tax Number')}}</label>
                                    <input type="text" name="tax_no" class="form-control"
                                        value="{{$lims_customer_data->tax_no}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>BIN Number</label>
                                    <input type="text" name="bin_no" class="form-control" value="{{$lims_customer_data->bin_number}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Address')}} *</label>
                                    <input type="text" name="address" required value="{{$lims_customer_data->address}}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.City')}} </label>
                                    <input type="text" name="city" value="{{$lims_customer_data->city}}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.State')}}</label>
                                    <input type="text" name="state" value="{{$lims_customer_data->state}}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Postal Code')}}</label>
                                    <input type="text" name="postal_code" value="{{$lims_customer_data->postal_code}}"
                                        class="form-control">
                                </div>
                            </div>
                            @if(!$lims_customer_data->user_id)
                            <div class="col-md-6 mt-3 d-none">
                                <div class="form-group">
                                    <label>{{trans('file.Add User')}}</label>&nbsp;
                                    <input type="checkbox" name="user" value="1" />
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Country')}}</label>
                                    <input type="text" name="country" value="{{$lims_customer_data->country}}"
                                        class="form-control">
                                </div>
                            </div>
                            @foreach($custom_fields as $field)
                            <?php $field_name = str_replace(' ', '_', strtolower($field->name)); ?>
                            @if(!$field->is_admin || \Auth::user()->role_id == 1)
                            <div class="{{'col-md-'.$field->grid_value}}">
                                <div class="form-group">
                                    <label>{{$field->name}}</label>
                                    @if($field->type == 'text')
                                    <input type="text" name="{{$field_name}}"
                                        value="{{$lims_customer_data->$field_name}}" class="form-control"
                                        @if($field->is_required){{'required'}}@endif>
                                    @elseif($field->type == 'number')
                                    <input type="number" name="{{$field_name}}"
                                        value="{{$lims_customer_data->$field_name}}" class="form-control"
                                        @if($field->is_required){{'required'}}@endif>
                                    @elseif($field->type == 'textarea')
                                    <textarea rows="5" name="{{$field_name}}"
                                        value="{{$lims_customer_data->$field_name}}" class="form-control"
                                        @if($field->is_required){{'required'}}@endif></textarea>
                                    @elseif($field->type == 'checkbox')
                                    <br>
                                    <?php
                                                $option_values = explode(",", $field->option_value);
                                                $field_values =  explode(",", $lims_customer_data->$field_name);
                                                ?>
                                    @foreach($option_values as $value)
                                    <label>
                                        <input type="checkbox" name="{{$field_name}}[]" value="{{$value}}"
                                            @if(in_array($value, $field_values)) checked @endif
                                            @if($field->is_required){{'required'}}@endif> {{$value}}
                                    </label>
                                    &nbsp;
                                    @endforeach
                                    @elseif($field->type == 'radio_button')
                                    <br>
                                    <?php 
                                                $option_values = explode(",", $field->option_value);
                                                ?>
                                    @foreach($option_values as $value)
                                    <label class="radio-inline">
                                        <input type="radio" name="{{$field_name}}" value="{{$value}}"
                                            @if($value==$lims_customer_data->$field_name){{'checked'}}@endif
                                        @if($field->is_required){{'required'}}@endif> {{$value}}
                                    </label>
                                    &nbsp;
                                    @endforeach
                                    @elseif($field->type == 'select')
                                    <?php $option_values = explode(",", $field->option_value); ?>
                                    <select class="form-control" name="{{$field_name}}"
                                        @if($field->is_required){{'required'}}@endif>
                                        @foreach($option_values as $value)
                                        <option value="{{$value}}" @if($value==$lims_customer_data->
                                            $field_name){{'selected'}}@endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @elseif($field->type == 'multi_select')
                                    <?php
                                                $option_values = explode(",", $field->option_value);
                                                $field_values =  explode(",", $lims_customer_data->$field_name);
                                                ?>
                                    <select class="form-control" name="{{$field_name}}[]"
                                        @if($field->is_required){{'required'}}@endif multiple>
                                        @foreach($option_values as $value)
                                        <option value="{{$value}}" @if(in_array($value, $field_values)) selected @endif>
                                            {{$value}}</option>
                                        @endforeach
                                    </select>
                                    @elseif($field->type == 'date_picker')
                                    <input type="text" name="{{$field_name}}"
                                        value="{{$lims_customer_data->$field_name}}" class="form-control date"
                                        @if($field->is_required){{'required'}}@endif>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="col-md-6 user-input">
                                <div class="form-group">
                                    <label>{{trans('file.UserName')}} *</label>
                                    <input type="text" name="name" class="form-control">
                                    @if($errors->has('name'))
                                    <span>
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 user-input">
                                <div class="form-group">
                                    <label>{{trans('file.Password')}} *</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>

                            <hr>

                            <div class="col-12 d-flex justify-content-between align-items-center mt-5 mb-2">
                                <h5>Contact Person Details:</h5>
                                <button type="button" class="btn btn-sm btn-primary" id="addContactPerson">+ Add More</button>
                            </div>

                            <div class="col-12" id="contactPersonWrapper">

                                @foreach($lims_customer_data->contactPersons as $i => $cp)
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
                                            <label>Visiting Card Front</label>
                                            <input type="file" name="contact_persons[{{$i}}][visiting_card_front]"
                                            class="form-control mt-2"><br>
                                            @if($cp->visiting_card_front)
                                            <img src="{{ asset('storage/'.$cp->visiting_card_front) }}"
                                                width="80">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>Visiting Card Back</label>
                                            <input type="file" name="contact_persons[{{$i}}][visiting_card_back]"
                                            class="form-control mt-2"><br>
                                            @if($cp->visiting_card_back)
                                            <img src="{{ asset('storage/'.$cp->visiting_card_back) }}"
                                                width="80">
                                            @endif
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

    $(".user-input").hide();

    $('input[name="user"]').on('change', function() {
        if ($(this).is(':checked')) {
            $('.user-input').show(300);
            $('input[name="name"]').prop('required',true);
            $('input[name="password"]').prop('required',true);
        }
        else{
            $('.user-input').hide(300);
            $('input[name="name"]').prop('required',false);
            $('input[name="password"]').prop('required',false);
        }
    });

    var customer_group = $("input[name='customer_group']").val();
    $('select[name=customer_group_id]').val(customer_group);

    let index = {{ count($lims_customer_data->contactPersons) }};

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