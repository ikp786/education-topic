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
								<h4>{{__('Manage Users Wallet')}}</h4>
							</div>
						</div>
					</div>
					<form action="{{route('wallet.index')}}" method="GET">
						<div class="widget-content widget-content-area">
							<div class="row">
								<div class="col-md-3">
									<select name="user_id" class="form-control mb-3 mb-md-0">
										<option value="">--Select User--</option>
										@foreach($users as $user)
											<option {{ old('user_id', isset($request) ? $request->user_id : '') == $user->user_id ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
										@endforeach
									</select>
								</div>
                                <div class="col-md-3">
                                    <select name="wallet_type" class="form-control">
                                        <option value="">--Select Wallet Type--</option>
                                        @foreach(config('constant.WALLET_TYPE') as $value => $key)
                                            <option {{ old('wallet_type', isset($request) ? $request->wallet_type : '') == $key ? 'selected' : ''}} value="{{$key}}">{{ ucwords(strtolower($value))}}</option>
                                        @endforeach
                                    </select>
                                </div>
								<!-- <div class="col-md-3">
									<input type="text" name="search" maxlength="32" class="form-control mb-3 mb-md-0" placeholder="Search Post" value="{{$request->search}}" onkeypress="return IsAlphaApos(event, this.value, '32')"> 
								</div> -->
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
										<th>UserName</th>
										<th>Transaction Amount</th>
										<th>Transaction Type</th>
										<th>Wallet Type</th>
										<th>Transaction Id</th>
										<th>Create Date</th>
										<!-- <th class="text-center">Action</th> -->
									</tr>
								</thead>
								<tbody>
									@if(count($record_list) > 0)
										@foreach($record_list as $record)
											<tr>
												<td>{{$record->user_data->full_name}}</td>
												<td>{{$record->tran_amount}}</td>
												<td>
													@foreach(config('constant.TRAN_TYPE') as $value => $key)
														{{ (isset($record) ? $record->tran_type : '') == $key ? ucwords(strtolower($value)) : ''}}
													@endforeach
												</td>
												<td>
													@foreach(config('constant.WALLET_TYPE') as $value => $key)
														{{ (isset($record) ? $record->wallet_type : '') == $key ? ucwords(strtolower($value)) : ''}}
													@endforeach
												</td>
												<td>{{$record->stripe_txn_id}}</td>
												<td>{{date('d F, Y', strtotime($record->created_at))}}</td>
												<!-- <td class="text-center">
													<ul class="table-controls">
														<li>
															<a href="{{route('wallet.show',base64_encode($record->post_id))}}" data-toggle="tooltip" data-placement="top" title="View">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
															</a>
														</li>
														<li>
															<a href="{{route('wallet.edit',base64_encode($record->post_id))}}" data-toggle="tooltip" data-placement="top" title="Edit">
																<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-primary"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
															</a>
														</li>
														<li>
															<form action="{{route('wallet.destroy',$record->user_id)}}" method="POST">
																@csrf
																@method('DELETE')
																<buttton type="submit" class="delete-user" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
															</form>
														</li>
													</ul>
												</td> -->
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