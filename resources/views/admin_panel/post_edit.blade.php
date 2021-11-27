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
                                <h4>{{ isset($record_data) ? 'Update' : 'Create' }} User Post</h4> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area custom-autocomplete h-100"> 
                        <form action="{{ route('users.store', isset($record_data) ? base64_encode($record_data->post_id) : base64_encode(0) ) }}" method="POST" enctype="multipart/form-data" id="general_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="post_title">Title</label>
                                    <input type="text" name="post_title" class="form-control basic" maxlength="100" value="{{ old('post_title', isset($record_data) ? $record_data->post_title : '') }}" placeholder="Title" onkeypress="return IsAlphaApos(event, this.value, '100')" required>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="meeting_url">Meeting url</label>
                                    <input type="text" name="meeting_url" class="form-control basic" maxlength="255" value="{{ old('meeting_url', isset($record_data) ? $record_data->meeting_url : '') }}" placeholder="Meeting url" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Subject</label>
                                    <select name="subject_id" class="form-control" id="slct" required>
                                        <option value="">== Select Subject ==</option>
                                        @foreach($subject_list as $subject)
                                            <option {{ old('subject_id', isset($record_data) ? $record_data->subject_id : '') == $subject->subject_id ? 'selected' : ''}} value="{{$subject->subject_id}}">{{ $subject->subject_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="email1">Language</label>
                                    <select name="language_id" class="form-control" required>
                                        <option value="">== Select Language ==</option>
                                        @foreach($language_list as $lang)
                                            <option {{ old('language_id', isset($record_data) ? $record_data->language_id : '') == $lang->language_id ? 'selected' : ''}} value="{{$lang->language_id}}">{{ $lang->language_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
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
                                <div class="form-group col-6 custom-file-container">
                                    <label for="post_details">Post Details</label>
                                    <textarea name="post_details" rows="4" class="form-control" placeholder="Post Details" required>{{$record_data->post_details}}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6 custom-file-container">
                                    <label for="post_status">Post Status</label>
                                    <select name="post_status" class="form-control" required>
                                        <option value="">== Select Post Status ==</option>
                                        @foreach(config('constant.POST_STATUS') as $value => $key)
                                            <option {{ old('post_status', isset($record_data) ? $record_data->post_status : '') == $key ? 'selected' : ''}} value="{{$key}}">{{ ucwords(strtolower($value))}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6 custom-file-container">
                                    <label for="admin_status">Admin Status</label>
                                    <select name="post_status" class="form-control" required>
                                        <option value="">== Select Admin Status ==</option>
                                        @foreach(config('constant.ADMIN_STATUS') as $value => $key)
                                            <option {{ old('admin_status', isset($record_data) ? $record_data->admin_status : '') == $key ? 'selected' : ''}} value="{{$key}}">{{ ucwords(strtolower($value))}}</option>
                                        @endforeach
                                    </select>
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