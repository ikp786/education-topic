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
								<h4>{{ isset($record_data) ? 'Update' : 'Create' }} Exam Questions</h4> 
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area custom-autocomplete h-100"> 
						<form action="{{ route('exam_questions.update', isset($record_data) ? base64_encode($record_data->exam_head_id) : base64_encode(0) ) }}" method="POST" enctype="multipart/form-data" id="general_form">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="form-group col-6 custom-file-container">
									<label for="exam_title">Exam Name</label>
									<input type="text" name="exam_title" class="form-control" maxlength="50" value="{{ old('exam_title', isset($record_data) ? $record_data->exam_title : '') }}" placeholder="Exam Name" onkeypress="return IsAlphaApos(event, this.value, '50')" required>
								</div>
								<div class="form-group col-6 custom-file-container">
									<label for="logo_img">Exam Logo</label>
									<input type="file" name="logo_img" class="form-control" accept="image/*">
									@if(isset($record_data) && !empty($record_data->exam_logo))
										<img src="{{asset('storage/exam_images/'.$record_data->exam_logo)}}" alt="exam_logo" width="80">
									@endif
								</div>
							</div>
							<div class="row">
								<div class="form-group col-4 custom-file-container">
									<label for="exam_date">Exam Date</label>
									<input type="date" name="exam_date" class="form-control" min="{{ isset($record_data) ? $record_data->exam_date : date('Y-m-d') }}" value="{{ old('exam_date', isset($record_data) ? $record_data->exam_date : date('Y-m-d') ) }}" placeholder="Exam Date" required>
								</div>
								<div class="form-group col-4 custom-file-container">
									<label for="start_time">Start Time</label>
									<input type="time" name="start_time" class="form-control" value="{{ old('start_time', isset($record_data) ? $record_data->start_time : '') }}" placeholder="Start Time" required>
								</div>
								<div class="form-group col-4 custom-file-container">
									<label for="end_time">End Time</label>
									<input type="time" name="end_time" class="form-control" value="{{ old('end_time', isset($record_data) ? $record_data->end_time : '') }}" placeholder="End Time" required>
								</div>
							</div>
							<hr>
							@if(isset($record_data->exam_questions))
								@foreach ($record_data->exam_questions as $key => $value)
									<div class="input-group ll">
										<div class="row">
											<div class="form-group">
												<label for="quizquestion">Quiz Question</label>
												<input type="text" name="question[]" class="form-control" placeholder="Enter a Question?" value="{{ $value->question_title }}" required>
												<input type="hidden" name="questionId[{{ $key }}]" value="{{ $value->question_id }}">
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6">
												<label for="answer_a">Option-A</label>
												<input type="text" name="answer_a[]" class="form-control" value="{{ $value->answer_a }}">
											</div>
											<div class="form-group col-md-6">
												<label for="answer_b">Option-B</label>
												<input type="text" name="answer_b[]" class="form-control" value="{{ $value->answer_b }}">
											</div>
											<div class="form-group col-md-6">
												<label for="answer_c">Option-C</label>
												<input type="text" name="answer_c[]" class="form-control" value="{{ $value->answer_c }}">
											</div>
											<div class="form-group col-md-6">
												<label for="answer_d">Option-D</label>
												<input type="text" name="answer_d[]" class="form-control" value="{{ $value->answer_d }}">
											</div>
										</div>

										<div class="form-group">
											<label for="rightAnswer">Right Answer</label><br>
											<label><input type="radio" name="rightAnswer[{{ $key }}][]" value="answer_a" @if($value->right_answer=='answer_a')checked @endif> Option-A </label>
											<label><input type="radio" name="rightAnswer[{{ $key }}][]" value="answer_b" @if($value->right_answer=='answer_b')checked @endif> Option-B </label>
											<label><input type="radio" name="rightAnswer[{{ $key }}][]" value="answer_c" @if($value->right_answer=='answer_c')checked @endif> Option-C </label>
											<label><input type="radio" name="rightAnswer[{{ $key }}][]" value="answer_d" @if($value->right_answer=='answer_d')checked @endif> Option-D </label>
										</div>
										<div class="input-group-addon">
											<a href="javascript:void(0)" class="removebtn" data-toggle="tooltip" data-placement="top" data-question_id="{{ $value->question_id }}" title="Delete"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>
										</div>
									</div>
									<hr>
								@endforeach
							@else
								<div class="input-group ll">
									<div class="row">
										<div class="form-group">
											<label for="quizquestion">Quiz Question</label>
											<input type="text" name="question[]" class="form-control" placeholder="Enter a Question?" required>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-6">
											<label for="answer_a">Option-A</label>
											<input type="text" name="answer_a[]" class="form-control">
										</div>
										<div class="form-group col-md-6">
											<label for="answer_b">Option-B</label>
											<input type="text" name="answer_b[]" class="form-control">
										</div>
										<div class="form-group col-md-6">
											<label for="answer_c">Option-C</label>
											<input type="text" name="answer_c[]" class="form-control">
										</div>
										<div class="form-group col-md-6">
											<label for="answer_d">Option-D</label>
											<input type="text" name="answer_d[]" class="form-control">
										</div>
									</div>

									<div class="form-group">
										<label for="rightAnswer">Right Answer</label><br>
										<label><input type="radio" name="rightAnswer[0][]" value="answer_a" checked> Option-A </label>
										<label><input type="radio" name="rightAnswer[0][]" value="answer_b" > Option-B </label>
										<label><input type="radio" name="rightAnswer[0][]" value="answer_c" > Option-C </label>
										<label><input type="radio" name="rightAnswer[0][]" value="answer_d" > Option-D </label>
									</div>
									<div class="input-group-addon">
										<a href="javascript:void(0)" class="removebtn" data-toggle="tooltip" data-placement="top" data-question_id="0" title="Delete"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>
									</div>
								</div>
								<hr>
							@endif

							<div id="addmQUiz"></div>
							<div class="row pull-right">
								<div class="form-group col-12 custom-file-container">
									<a href="javascript:;" class="btn btn-primary" id="addmoreQuiz">Add More</a>
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