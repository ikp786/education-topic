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
								<h4>View User Profile</h4> 
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area custom-autocomplete h-100">
						<div class="table-responsive">
							<table class="table table-bordered mb-4 table-hover">
								<tbody>
									<tr>
										<td width="20%">Name</td>
										<td width="2%">:</td>
										<td>{{$record_data->full_name}}</td>
									</tr>
									<tr>
										<td>Email Address</td>
										<td>:</td>
										<td>{{$record_data->email_address}}</td>
									</tr>
									<tr>
										<td>Mobile Number</td>
										<td>:</td>
										<td>{{$record_data->mobile_number}}</td>
									</tr>
									<tr>
										<td>Intrests</td>
										<td>:</td>
										<td>{{$intrest_data}}</td>
									</tr>
									<tr>
										<td>Language</td>
										<td>:</td>
										<td>{{$language_data}}</td>
									</tr>
									<tr>
										<td>Profession</td>
										<td>:</td>
										<td>{{$record_data->profession_data->profession_title}}</td>
									</tr>
									<tr>
										<td>Gender</td>
										<td>:</td>
										<td>@if($record_data->gender_id==1001)Male @elseif($record_data->gender_id==1002)Female @else Other @endif</td>
									</tr>
									<tr>
										<td>College Name</td>
										<td>:</td>
										<td>{{$record_data->college_name}}</td>
									</tr>
									<tr>
										<td>Create Date</td>
										<td>:</td>
										<td>{{date('d F, Y', strtotime($record_data->created_at))}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<hr>
					
					<div class="widget-header">                                
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>Profile Image</h4> 
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area custom-autocomplete h-100">
						<div class="row">
							<div class="form-group col-2 custom-file-container">
								@if($record_data->user_image)
								<a href="{{asset('storage/user_images/'.$record_data->user_image)}}" target="_blank">
									<img src="{{asset('storage/user_images/'.$record_data->user_image)}}" alt="user img" width="200">
								</a>
								@endif
							</div>
						</div>
					</div>
					<hr>

				</div>
			</div>
		</div>
	</div>
@endsection  