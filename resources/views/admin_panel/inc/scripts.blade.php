<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script>
	$(document).ready(function() {
		App.init();
	});
</script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/js/dashboard/dash_1.js')}}"></script>
<script src="{{asset('plugins/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
<script src="{{asset('plugins/bootstrap-maxlength/custom-bs-maxlength.js')}}"></script>
<script src="{{asset('assets/js/form-validation.min.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('plugins/select2/custom-select2.js')}}"></script>
<script src="{{asset('plugins/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script src="{{asset('plugins/editors/markdown/simplemde.min.js')}}"></script>
<script src="{{asset('plugins/editors/markdown/custom-markdown.js')}}"></script>

<script src="//cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>
	$(document).ready(function() {
		CKEDITOR.replaceClass = 'ckeditor';
	});
</script>

<script>
	checkall('todoAll', 'todochkbox');
	$('[data-toggle="tooltip"]').tooltip()
	$('selector').maxlength();
	new SimpleMDE({
		element: document.getElementById("ck_editor"),
		spellChecker: false,
	});
	$(".tagging").select2({
		tags: true
	});

	$('.delete-user').click(function(e){
		if (confirm('Are you sure to delete ?')) {
			$(e.target).closest('form').submit();
		}
	});

	$('.admin_status').change(function () {
		var admin_status = $(this).val();
		var post_id = $(this).data('post_id');
		//alert(post_id);
		$.ajax({
			type: "POST",
			url: "{{route('posts.admin_status_update')}}",
			data: {"_token": "{{ csrf_token() }}", "post_id": post_id, "admin_status": admin_status},
			dataType: "json",
			success: function (response){
				if (response.success == true) {
					// var url ="{{ route('users.index') }}"; //the url I want to redirect to
					// $(location).attr('href', url);
					window.location.reload();
				}
			}
		});
	});

	$('.video_admin_status').change(function () {
		var admin_status = $(this).val();
		var video_id = $(this).data('video_id');
		//alert(video_id);
		$.ajax({
			type: "POST",
			url: "{{route('videos.admin_status_update')}}",
			data: {"_token": "{{ csrf_token() }}", "video_id": video_id, "admin_status": admin_status},
			dataType: "json",
			success: function (response){
				if (response.success == true) {
					// var url ="{{ route('users.index') }}"; //the url I want to redirect to
					// $(location).attr('href', url);
					window.location.reload();
				}
			}
		});
	});

	$('.scholarship_admin_status').change(function () {
		var admin_status = $(this).val();
		var scholarship_id = $(this).data('scholarship_id');
		//alert(post_id);
		$.ajax({
			type: "POST",
			url: "{{route('scholarship.admin_status_update')}}",
			data: {"_token": "{{ csrf_token() }}", "scholarship_id": scholarship_id, "admin_status": admin_status},
			dataType: "json",
			success: function (response){
				if (response.success == true) {
					// var url ="{{ route('scholarship.index') }}"; //the url I want to redirect to
					// $(location).attr('href', url);
					window.location.reload();
				}
			}
		});
	});

	$('.withdraw_admin_status').change(function () {
		var admin_status = $(this).val();
		var withdraw_id = $(this).data('withdraw_id');
		//alert(withdraw_id);
		$.ajax({
			type: "POST",
			url: "{{route('withdraw.admin_status_update')}}",
			data: {"_token": "{{ csrf_token() }}", "withdraw_id": withdraw_id, "admin_status": admin_status},
			dataType: "json",
			success: function (response){
				if (response.success == true) {
					// var url ="{{ route('withdraw.list') }}"; //the url I want to redirect to
					// $(location).attr('href', url);
					window.location.reload();
				}
			}
		});
	});

	//add More Questions
	$("#addmoreQuiz").click(function(){
		var lt=$('body').find('.ll').length;
		console.log(lt);
		var ht='<div class="input-group ll"><div class="row"><div class="form-group"><label for="question">Quiz Question '+lt+'</label><input type="text" name="question[]" class="form-control" placeholder="Enter a Question?" required></div></div><div class="row"><div class="form-group col-md-6"><label for="answer_a">Option-A</label><input type="text" name="answer_a[]" class="form-control"></div><div class="form-group col-md-6"><label for="answer_b">Option-B</label><input type="text" name="answer_b[]" class="form-control"></div><div class="form-group col-md-6"><label for="answer_c">Option-C</label><input type="text" name="answer_c[]" class="form-control"></div><div class="form-group col-md-6"><label for="answer_d">Option-D</label><input type="text" name="answer_d[]" class="form-control"></div></div><div class="form-group"><label for="rightAnswer">Right Answer</label><br><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_a" checked> Option-A </label><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_b"> Option-B </label><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_c"> Option-C </label><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_d"> Option-D </label></div><div class="input-group-addon"><a href="javascript:void(0)" class="removebtn" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a></div></div>';
		
		$('#addmQUiz').append(ht);
		
	});
	$("body").on("click",".removebtn",function(){ 
		var question_id = $(this).data('question_id');
		if(confirm("Are you sure?"))
		{
			//alert(questionId);
			$(this).parents(".input-group").remove();
			//$(this).parent('div').parent('div').remove();
			$.ajax({
				type: "POST",
				url: "{{route('exam_questions.delete')}}",
				data: { _token: "{{ csrf_token() }}", question_id:question_id },
				success: function( response ) {
					//$('#questionId').html(response);
					//window.location.reload();
				}
			});
			//window.location.reload();
		}
	});

	//add More Mockup Questions
	$("#addmoreMockupQuiz").click(function(){
		var lt=$('body').find('.ll').length;
		console.log(lt);
		var ht='<div class="input-group ll"><div class="row"><div class="form-group"><label for="question">Quiz Question '+lt+'</label><input type="text" name="question[]" class="form-control" placeholder="Enter a Question?" required></div></div><div class="row"><div class="form-group col-md-6"><label for="answer_a">Option-A</label><input type="text" name="answer_a[]" class="form-control"></div><div class="form-group col-md-6"><label for="answer_b">Option-B</label><input type="text" name="answer_b[]" class="form-control"></div><div class="form-group col-md-6"><label for="answer_c">Option-C</label><input type="text" name="answer_c[]" class="form-control"></div><div class="form-group col-md-6"><label for="answer_d">Option-D</label><input type="text" name="answer_d[]" class="form-control"></div></div><div class="form-group"><label for="rightAnswer">Right Answer</label><br><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_a" checked> Option-A </label><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_b"> Option-B </label><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_c"> Option-C </label><label><input type="radio" name="rightAnswer['+lt+'][]" value="answer_d"> Option-D </label></div><div class="input-group-addon"><a href="javascript:void(0)" class="removeMockupQuesBtn" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a></div></div>';
		
		$('#addMockupQUiz').append(ht);
		
	});
	$("body").on("click",".removeMockupQuesBtn",function(){ 
		var question_id = $(this).data('question_id');
		if(confirm("Are you sure?"))
		{
			//alert(questionId);
			$(this).parents(".input-group").remove();
			$.ajax({
				type: "POST",
				url: "{{route('mockup_exam_questions.delete')}}",
				data: { _token: "{{ csrf_token() }}", question_id:question_id },
				success: function( response ) {
					//$('#questionId').html(response);
					//window.location.reload();
				}
			});
		}
	});
</script>
