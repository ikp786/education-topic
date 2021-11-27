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
                                <h4>{{ isset($record_data) ? 'Update' : 'Create' }} Admin User</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area custom-autocomplete h-100"> 
                        <form action="{{ route('admin.update', isset($record_data) ? base64_encode($record_data->id) : base64_encode(0) ) }}" method="POST" enctype="multipart/form-data" id="general_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="full_name">FullName</label>
                                    <input type="text" class="form-control basic" maxlength="30" name="full_name" value="{{ old('full_name', isset($record_data) ? $record_data->full_name : '') }}" placeholder="FullName" onkeypress="return IsAlphaApos(event, this.value, '30')" required>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Email Address</label>
                                    <input type="text" class="form-control basic" maxlength="50" name="email_address" value="{{ old('email_address', isset($record_data) ? $record_data->email_address : '') }}" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="form-group col-6 custom-file-container">
                                    <label for="admin_photo">Image</label>
                                    <input type="file" class="form-control basic" name="admin_photo" accept="image/*">
                                </div> -->
                                <div class="form-group col-6 custom-file-container">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control basic" maxlength="20" placeholder="Password" autocomplete="new-password">
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