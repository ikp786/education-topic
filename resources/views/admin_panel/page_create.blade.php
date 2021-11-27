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
                                <h4>{{ isset($record_data) ? 'Update' : 'Create' }} Page</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area custom-autocomplete h-100"> 
                        <form action="{{ route('pages.update', isset($record_data) ? base64_encode($record_data->page_id) : base64_encode(0) ) }}" method="POST" enctype="multipart/form-data" id="general_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12 custom-file-container">
                                    <label for="page_title">Page Title</label>
                                    <input type="text" class="form-control basic" maxlength="100" name="page_title" value="{{ old('page_title', isset($record_data) ? $record_data->page_title : '') }}" placeholder="Page Title" onkeypress="return IsAlphaApos(event, this.value, '100')" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 custom-file-container">
                                    <label for="page_details">Page Content</label>
                                    <textarea name="page_details" class="form-control basic ckeditor" rows="6" placeholder="Page Content" required>{!! old('page_details', isset($record_data) ? $record_data->page_details : '') !!}</textarea>
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