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
								<h4>Exam Questions Bulk Upload</h4>
								<a href="{{asset('sample_files/sample_question_bulk_upload_file.csv')}}" class="btn btn-primary pull-right" target="_blank">Download Sample File</a>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area custom-autocomplete h-100"> 
						<form action="{{ route('exam_questions.bulkUpload') }}" method="POST" enctype="multipart/form-data" id="general_form">
							@csrf
							<div class="row">
								<div class="form-group col-6 custom-file-container">
									<label for="exam_head_id">Exam Name</label>
									<select name="exam_head_id" class="form-control" required>
										<option value="">--select exam--</option>
										@if($exam_list)
										@foreach($exam_list as $exam)
										<option value="{{$exam->exam_head_id}}">{{$exam->exam_title}}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-6 custom-file-container">
									<label for="upload_file">Upload File</label>
									<input type="file" name="upload_file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
								</div>
							</div>
							<hr>
							<button type="submit" class="btn btn-primary">{{__('Save & Exit')}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection  