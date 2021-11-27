@extends('admin_panel.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="ftFormArray" class="col-lg-12 layout-spacing">
                @include('admin_panel.inc.validation_message')
                @include('admin_panel.inc.auth_message')
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">                                
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>{{ isset($record_data) ? 'Update' : 'Create' }} User</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area custom-autocomplete h-100"> 
                        <form action="{{ route('users.store', isset($record_data) ? base64_encode($record_data->user_id) : base64_encode(0) ) }}" method="POST" enctype="multipart/form-data" id="general_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">FullName</label>
                                    <input type="text" class="form-control basic" maxlength="30" name="full_name" value="{{ old('full_name', isset($record_data) ? $record_data->full_name : '') }}" placeholder="FullName" onkeypress="return IsAlphaApos(event, this.value, '30')" required>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Email Address</label>
                                    <input type="text" class="form-control basic" maxlength="50" name="email_address" value="{{ old('email_address', isset($record_data) ? $record_data->email_address : '') }}" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Mobile Number</label>
                                    <input type="text" class="form-control basic" maxlength="10" name="mobile_number" value="{{ old('mobile_number', isset($record_data) ? $record_data->mobile_number : '') }}" placeholder="Mobile Number" onkeypress="return IsNumber(event, this.value, '10')" required>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">College Name</label>
                                    <input type="text" class="form-control basic" maxlength="100" name="college_name" value="{{ old('college_name', isset($record_data) ? $record_data->college_name : '') }}" placeholder="College Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Gender</label>
                                    <select name="gender_id" class="form-control" id="slct" required>
                                        <option value="">== Select Gender ==</option>
                                        @foreach(config('constant.GENDER') as $value => $key)
                                            <option {{ old('gender_id', isset($record_data) ? $record_data->gender_id : '') == $key ? 'selected' : ''}} value="{{$key}}">{{ ucwords(strtolower($value))}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Intrests</label>
                                    @if(isset($record_data) && !empty($record_data->intrest_id))
                                        @php $intrests = explode(",", $record_data->intrest_id); @endphp
                                    @endif
                                    <select name="intrest_id[]" class="form-control" multiple="" required>
                                        <!-- <option value="">== Select Intrests ==</option> -->
                                        @foreach($intrest_list as $rec)
                                            <option {{ old('intrest_id', isset($record_data) && in_array($rec->intrest_id, $intrests)) ? 'selected' : ''}} value="{{$rec->intrest_id}}">{{ $rec->intrest_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Language</label>
                                    <select name="language_id" class="form-control" required>
                                        <option value="">== Select Language ==</option>
                                        @foreach($language_list as $lang)
                                            <option {{ old('language_id', isset($record_data) ? $record_data->language_id : '') == $lang->language_id ? 'selected' : ''}} value="{{$lang->language_id}}">{{ $lang->language_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Profession</label>
                                    <select name="gender_id" class="form-control" id="slct" required>
                                        <option value="">== Select Profession ==</option>
                                        @foreach($profession_list as $profession)
                                            <option {{ old('profession_id', isset($record_data) ? $record_data->profession_id : '') == $profession->profession_id ? 'selected' : ''}} value="{{$profession->profession_id}}">{{ $profession->profession_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Image</label>
                                    <input type="file" class="form-control basic" name="user_photo" accept="image/*" required>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Password</label>
                                    <input type="password" class="form-control basic" maxlength="20" name="password" value="" placeholder="Password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Save & Exit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection  