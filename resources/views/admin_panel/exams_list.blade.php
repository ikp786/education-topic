@extends('admin_panel.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row layout-top-spacing">
			<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
				@include('admin_panel.inc.validation_message')
				@include('admin_panel.inc.auth_message')
				<div class="statbox widget box box-shadow mb-1">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4>{{__('Manage Exam Questions')}}</h4>
							</div>
						</div>
					</div>
					<form action="{{route('exam_questions.index')}}" method="GET">
						<div class="widget-content widget-content-area">
							<div class="row">
								<div class="col-md-3">
									<input type="text" name="search" maxlength="32" class="form-control mb-3 mb-md-0" placeholder="Exam Name" value="{{$request->search}}" onkeypress="return IsAlphaApos(event, this.value, '32')"> 
								</div>
								<div class="col-md-3 d-flex">
									<button class="btn btn-primary mr-3" type="submit">
										Filter
									</button>
									<button class="btn btn-danger" type="button" id="ClearFilter">
										Clear Filter
									</button>
								</div>

							</div>
						</div>
					</form>
				</div>
				<div class="statbox widget box box-shadow">
					<div class="widget-content widget-content-area">
						<div class="table-responsive">
							<table class="table table-bordered mb-4 table-hover">
								<thead>
									<tr>
										<th>Exam Name</th>
										<th>Exam Logo</th>
										<th>Exam Date</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Attemped</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									@if(count($record_list) > 0)
										@foreach($record_list as $record)
											<tr>
												<td>{{$record->exam_title}}</td>
												<td>
													@if(!empty($record->exam_logo))
														<img src="{{asset('storage/exam_images')}}/{{$record->exam_logo}}" width="100" />
													@else
														<span class="order_model"><b>Pending</b></span>
													@endif
												</td>
												<td>{{date('d F, Y', strtotime($record->exam_date))}}</td>
												<td>{{$record->start_time}}</td>
												<td>{{$record->end_time}}</td>
												<td>{{count($record->result_data)}} <a href="{{route('exam_questions.result',base64_encode($record->exam_head_id))}}" data-toggle="tooltip" data-placement="top" title="View Result"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a></td>
												<td class="text-center">
													<ul class="table-controls">
														<!-- <li>
															<a href="#" data-toggle="tooltip" data-placement="top" title="View">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
															</a>
														</li> -->
														<li>
															<a href="{{route('exam_questions.edit',base64_encode($record->exam_head_id))}}" data-toggle="tooltip" data-placement="top" title="Edit">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit text-primary"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
															</a>
														</li>
														<!-- <li>
															<form action="{{route('exam_questions.destroy',$record->exam_head_id)}}" method="POST">
																@csrf
																@method('DELETE')
																<buttton type="submit" class="delete-user" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
															</form>
														</li> -->
													</ul>
												</td>
											</tr>
										@endforeach
									@else
										<tr><td colspan="6" align="center"><strong>No record's found</strong></td></tr>
									@endif
								</tbody>
							</table>
						</div>
						<div class="paginating-container pagination-solid justify-content-end">
							{{$record_list->appends($request->all())->render('vendor.pagination.custom')}}
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection  