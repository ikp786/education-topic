@extends('admin_panel.layouts.app')
@section('content')
<style>
svg.feather-eye {
    position: absolute;
    top: 42px;
    right: 24px;
    color: #888ea8;
    fill: rgba(0, 23, 55, 0.08);
    width: 17px;
    cursor: pointer;
}
</style>
    <div class="container-fluid">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="ftFormArray" class="col-lg-12 layout-spacing">
                @include('admin_panel.inc.validation_message')
                @include('admin_panel.inc.auth_message')
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">                                
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>{{ __('Change Password') }}</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area custom-autocomplete h-100"> 
                        <form action="{{ route('change.password.post')}}" method="POST" enctype="multipart/form-data" id="general_form">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Old Password</label>
                                    <input type="password" class="form-control basic" maxlength="16" name="login_password" id="login_password" value="{{ old('login_password') }}" placeholder="Old Password" required>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="ShowPass('login_password')" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">New Password</label>
                                    <input type="password" class="form-control basic" maxlength="16" name="new_password" id="new_password" value="{{ old('new_password') }}" placeholder="New Password" required>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="ShowPass('new_password')" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Confirm Password</label>
                                    <input type="password" class="form-control basic" maxlength="16" name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password" required>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="ShowPass('confirm_password')" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Update Password')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function ShowPass(id)
        {
            var x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection  