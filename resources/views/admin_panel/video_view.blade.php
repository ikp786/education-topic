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
								<h4>View User Video Post</h4> 
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area custom-autocomplete h-100">
						<div class="table-responsive">
							<table class="table table-bordered mb-4 table-hover">
								<tbody>
									<tr>
										<td width="20%">Title</td>
										<td width="2%">:</td>
										<td>{{$record_data->video_title}}</td>
									</tr>
									<tr>
										<td>Details</td>
										<td>:</td>
										<td>{{$record_data->video_details}}</td>
									</tr>
									<tr>
										<td>Video</td>
										<td>:</td>
										<td><a href="{{asset('storage/post_videos')}}/{{$record_data->video_url}}" target="_blank">{{asset('storage/post_videos')}}/{{$record_data->video_url}}</a></td>
									</tr>
									<tr>
										<td>Subject</td>
										<td>:</td>
										<td>{{$record_data->subject_data->subject_title}}</td>
									</tr>
									<tr>
										<td>Language</td>
										<td>:</td>
										<td>{{$record_data->language_data->language_title}}</td>
									</tr>
									<tr>
										<td>Intrests</td>
										<td>:</td>
										<td>{{$intrest_data}}</td>
									</tr>
									<tr>
										<td>Status</td>
										<td>:</td>
										<td>@if($record_data->video_status==106)Closed @elseif($record_data->video_status==107)Solved @else Open @endif</td>
									</tr>
									<tr>
										<td>Admin Status</td>
										<td>:</td>
										<td>@if($record_data->admin_status==109)Approved @elseif($record_data->admin_status==110)Rejected @else Pending @endif</td>
									</tr>
									<tr>
										<td>Create Date</td>
										<td>:</td>
										<td>{{date('d F, Y', strtotime($record_data->created_at))}}</td>
									</tr>
									<tr>
										<td>Total Likes</td>
										<td>:</td>
										<td>{{$record_data->like_post_count->count()}}</td>
									</tr>
									<tr>
										<td>Total Comments</td>
										<td>:</td>
										<td>{{$record_data->commnet_count->count()}}</td>
									</tr>
									<tr>
										<td>Total Views</td>
										<td>:</td>
										<td>{{$record_data->view_post_count->count()}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<hr>
					<!-- @if($record_data->video_url != '')
						<div class="widget-header">                                
							<div class="row">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12">
									<h4>Video</h4> 
								</div>
							</div>
						</div>
						<div class="widget-content">
							<div class="row">
								<div class="form-group col-2 custom-file-container">
									<a href="{{$record_data->video_url}}" target="_blank">
										<img src="{{asset('assets/img/video.png')}}" alt="video file">
									</a>
								</div>
							</div>
						</div>
						<hr>
					@endif -->

					@if(count($record_data->commnet_personal) > 0)
						<div class="widget-header">                                
							<div class="row">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12">
									<h4>Video Post Comments</h4> 
								</div>
							</div>
						</div>
						<div class="widget-content widget-content-area custom-autocomplete h-100">
							@foreach($record_data->commnet_personal as $key => $comment)
								<div class="border mb-4 p-3">
									<div class="row">
										<div class="form-group col-11 custom-file-container">
											<label for="comment_details"><b>{{++$key}} Comment by:</b> {{$comment->user_data->full_name}} ({{$comment->user_data->email_address}})</label>
											<div>{{$comment->comment_details}}</div>
										</div>
										<div class="form-group col-1 custom-file-container">
											<a href="{{ route('posts.comment_delete', $comment->comment_id) }}" data-toggle="tooltip" data-placement="top" onclick="return confirm('Are you sure, want to delete it?')" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>
										</div>
									</div>
									<hr>
									<!-- <form action="{{ route('posts.comment_update', $comment->comment_id) }}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="row">
											<div class="form-group col-9 custom-file-container">
												<label for="comment_details"><b> Comment by:</b> {{$comment->user_data->full_name}} ({{$comment->user_data->email_address}})</label>
												<textarea name="comment_details" class="form-control" placeholder="User Comment" required>{{$comment->comment_details}}</textarea>
											</div>
											<div class="form-group col-3 custom-file-container">
												<label for="action"><b>Action</b></label><br>
												<button type="submit" class="btn btn-primary">{{__('Update')}}</button>
												<a href="{{ route('posts.comment_delete', $comment->comment_id) }}" class="btn btn-danger" onclick="return confirm('Are you sure, you want to delete it?')">{{__('Remove')}}</a>
											</div>
										</div>
									</form> -->
									<div class="col-xl-11 col-md-11 col-sm-11 col-11 mx-auto">
										@foreach($comment->reply_data as $key1 => $reply_data)
											<div class="row">
												<div class="form-group col-11 custom-file-container">
													<label for="comment_details"><b>{{$key}}.{{++$key1}} Reply by:</b> {{$reply_data->user_data->full_name}} ({{$reply_data->user_data->email_address}})</label>
													<div>{{$reply_data->comment_details}}</div>
												</div>
												<div class="form-group col-1 custom-file-container">
													<a href="{{ route('posts.comment_delete', $reply_data->comment_id) }}" data-toggle="tooltip" data-placement="top" onclick="return confirm('Are you sure, want to delete it?')" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>
												</div>
											</div>
											<!-- <form action="{{ route('posts.comment_update', $reply_data->comment_id) }}" method="POST" enctype="multipart/form-data">
												@csrf
												<div class="row">
													<div class="form-group col-9 custom-file-container">
														<label for="comment_details"><b> Reply by:</b> {{$reply_data->user_data->full_name}} ({{$reply_data->user_data->email_address}})</label>
														<textarea name="comment_details" class="form-control" placeholder="User Reply Comment" required>{{$reply_data->comment_details}}</textarea>
													</div>
													<div class="form-group col-3 custom-file-container">
														<label for="action"><b>Action</b></label><br>
														<button type="submit" class="btn btn-primary">{{__('Update')}}</button>
														<a href="{{ route('posts.comment_delete', $reply_data->comment_id) }}" class="btn btn-danger" onclick="return confirm('Are you sure, you want to delete it?')">{{__('Remove')}}</a>
													</div>
												</div>
											</form> -->
										@endforeach
									</div>
								</div>
							@endforeach
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection  