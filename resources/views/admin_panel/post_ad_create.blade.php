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
                                <h4>{{ isset($record_data) ? 'Update' : 'Create' }} Post Ad</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area custom-autocomplete h-100"> 
                        <form action="{{ route('post_ads.update', isset($record_data) ? base64_encode($record_data->ad_id) : base64_encode(0) ) }}" method="POST" enctype="multipart/form-data" id="general_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12 custom-file-container">
                                    <label for="email1">Post Ad Image</label>
                                    <input type="file" name="ad_image_file" class="form-control" accept="image/*" required>
                                    @if(!empty($record_data->ad_image))
                                        <img src="{{asset('storage/postad_images')}}/{{$record_data->ad_image}}" width="100" />
                                    @endif
                                </div>
                                <div class="form-group col-12 custom-file-container">
                                    <label for="email1">Post Ad Url</label>
                                    <input type="text" name="ad_url" class="form-control" value="{{ old('ad_url', isset($record_data) ? $record_data->ad_url : '') }}" placeholder="Post Ad Url" required>
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