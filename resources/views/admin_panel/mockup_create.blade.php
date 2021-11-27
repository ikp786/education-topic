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
                                <h4>{{ isset($record_data) ? 'Update' : 'Create' }} Mockup</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area custom-autocomplete h-100"> 
                        <form action="{{ route('mockup.update', isset($record_data) ? base64_encode($record_data->mockup_id) : base64_encode(0) ) }}" method="POST" enctype="multipart/form-data" id="general_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="mockup_title">Mockup Title</label>
                                    <input type="text" name="mockup_title" class="form-control" value="{{ old('mockup_title', isset($record_data) ? $record_data->mockup_title : '') }}" placeholder="Mockup Title" required>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="mockup_price">Mockup Price</label>
                                    <input type="number" name="mockup_price" class="form-control" min="1" value="{{ old('mockup_price', isset($record_data) ? $record_data->mockup_price : '') }}" placeholder="Mockup Price" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 custom-file-container">
                                    <label for="mockup_image_file">Mockup Image</label>
                                    <input type="file" name="mockup_image_file" class="form-control" accept="image/*" {{isset($record_data) ? '' : 'required'}}>
                                    @if(!empty($record_data->mockup_image))
                                        <img src="{{asset('storage/mockup_images')}}/{{$record_data->mockup_image}}" width="100" />
                                    @endif
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