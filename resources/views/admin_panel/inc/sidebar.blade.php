<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
			
	<nav id="sidebar">
		<div class="shadow-bottom"></div>
		<ul class="list-unstyled menu-categories" id="accordionExample">
			<li class="menu">
				<a href="{{route('dashboard')}}" data-active="{{ Request::is('control_panel/dashboard') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
						<span>Dashboard</span>
					</div>
				</a>
			</li>
			<li class="menu">
				<a href="{{route('users.index')}}" data-active="{{ Request::is('control_panel/users*') || Request::is('control_panel/post_list/*') || Request::is('control_panel/video_list/*') || Request::is('control_panel/post_view/*') || Request::is('control_panel/video_post_view/*') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
						<span>Users</span>
					</div>
				</a>
			</li>
			<!-- <li class="menu">
				<a href="#users" data-toggle="collapse" data-active="{{ Request::is('control_panel/users*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('users/create') || Request::is('users') || Request::is('users/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('users/create') || Request::is('users') || Request::is('users/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Users</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/users*') ? 'collapse show' : '' }}" id="users" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/users/create') || Request::is('control_panel/users/*/edit') ? 'active' : '' }}">
						<a href="{{route('users.create')}}"> Create User </a>
					</li>
					<li class="{{ Request::is('control_panel/users') ? 'active' : '' }}">
						<a href="{{route('users.index')}}"> Users Listing </a>
					</li>
				</ul>
			</li> -->
			<li class="menu">
				<a href="#approval" data-toggle="collapse" data-active="{{ Request::is('control_panel/post_list') || Request::is('control_panel/video_list') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('control_panel/post_list') || Request::is('control_panel/video_list') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('control_panel/post_list') || Request::is('control_panel/video_list') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Admin Approval</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/post_list') || Request::is('control_panel/video_list') ? 'collapse show' : '' }}" id="approval" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/post_list') ? 'active' : '' }}">
						<a href="{{route('posts.list')}}"> Posts </a>
					</li>
					<li class="{{ Request::is('control_panel/video_list') ? 'active' : '' }}">
						<a href="{{route('videos.list')}}"> Video Posts </a>
					</li>                           
				</ul>
			</li>
			<li class="menu">
				<a href="#post_ads" data-toggle="collapse" data-active="{{ Request::is('control_panel/post_ads*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('post_ads/create') || Request::is('post_ads') || Request::is('post_ads/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('post_ads/create') || Request::is('post_ads') || Request::is('post_ads/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Post Ads</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/post_ads*') ? 'collapse show' : '' }}" id="post_ads" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/post_ads/create') || Request::is('control_panel/post_ads/*/edit') ? 'active' : '' }}">
						<a href="{{route('post_ads.create')}}"> Create Post Ad </a>
					</li>
					<li class="{{ Request::is('control_panel/post_ads') ? 'active' : '' }}">
						<a href="{{route('post_ads.index')}}"> Post Ads Listing  </a>
					</li>                           
				</ul>
			</li>
			<li class="menu">
				<a href="#exam_questions" data-toggle="collapse" data-active="{{ Request::is('control_panel/exam_questions*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('exam_questions/create') || Request::is('exam_questions') || Request::is('exam_questions/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('exam_questions/create') || Request::is('exam_questions') || Request::is('exam_questions/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Exams</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/exam_questions*') ? 'collapse show' : '' }}" id="exam_questions" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/exam_questions/create') || Request::is('control_panel/exam_questions/*/edit') ? 'active' : '' }}">
						<a href="{{route('exam_questions.create')}}"> Create Exam </a>
					</li>
					<li class="{{ Request::is('control_panel/exam_questions') ? 'active' : '' }}">
						<a href="{{route('exam_questions.index')}}"> Exam Listing </a>
					</li>
					<li class="{{ Request::is('control_panel/exam_questions_bulk_upload') ? 'active' : '' }}">
						<a href="{{route('exam_questions.getBulkUpload')}}"> Question Bulk Upload </a>
					</li>
				</ul>
			</li>
			<li class="menu">
				<a href="#mockup" data-toggle="collapse" data-active="{{ Request::is('control_panel/mockup*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('mockup/create') || Request::is('mockup') || Request::is('mockup/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('mockup/create') || Request::is('mockup') || Request::is('mockup/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Mockup Exams</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/mockup*') ? 'collapse show' : '' }}" id="mockup" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/mockup/create') || Request::is('control_panel/mockup/*/edit') ? 'active' : '' }}">
						<a href="{{route('mockup.create')}}"> Create Mockup </a>
					</li>
					<li class="{{ Request::is('control_panel/mockup') ? 'active' : '' }}">
						<a href="{{route('mockup.index')}}"> Mockup Listing </a>
					</li>
					<li class="{{ Request::is('control_panel/mockup_exam_questions/create') || Request::is('control_panel/mockup_exam_questions/*/edit') ? 'active' : '' }}">
						<a href="{{route('mockup_exam_questions.create')}}"> Create Mockup Exam </a>
					</li>
					<li class="{{ Request::is('control_panel/mockup_exam_questions') ? 'active' : '' }}">
						<a href="{{route('mockup_exam_questions.index')}}"> Mockup Exam Listing </a>
					</li>
					<li class="{{ Request::is('control_panel/mockup_exam_questions_bulk_upload') ? 'active' : '' }}">
						<a href="{{route('mockup_exam_questions.getBulkUpload')}}"> Question Bulk Upload </a>
					</li>
				</ul>
			</li>
			<li class="menu">
				<a href="{{route('subscription.index')}}" data-active="{{ Request::is('control_panel/subscription') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Subscription</span>
					</div>
				</a>
			</li>
			<li class="menu">
				<a href="{{route('scholarship.index')}}" data-active="{{ Request::is('control_panel/scholarship') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Scholarship</span>
					</div>
				</a>
			</li>
			<li class="menu">
				<a href="{{route('wallet.index')}}" data-active="{{ Request::is('control_panel/wallet') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Wallet</span>
					</div>
				</a>
			</li>
			<li class="menu">
				<a href="{{route('withdraw.list')}}" data-active="{{ Request::is('control_panel/withdraw') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Withdraw</span>
					</div>
				</a>
			</li>
			<li class="menu">
				<a href="{{route('contact.index')}}" data-active="{{ Request::is('control_panel/contact') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Contacts Query</span>
					</div>
				</a>
			</li>
			<li class="menu">
				<a href="#intrest" data-toggle="collapse" data-active="{{ Request::is('control_panel/intrest*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('intrest/create') || Request::is('intrest') || Request::is('intrest/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('intrest/create') || Request::is('intrest') || Request::is('intrest/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Intrest</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/intrest*') ? 'collapse show' : '' }}" id="intrest" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/intrest/create') || Request::is('control_panel/intrest/*/edit') ? 'active' : '' }}">
						<a href="{{route('intrest.create')}}"> Create Intrest </a>
					</li>
					<li class="{{ Request::is('control_panel/intrest') ? 'active' : '' }}">
						<a href="{{route('intrest.index')}}"> Intrest Listing  </a>
					</li>                           
				</ul>
			</li>
			<li class="menu">
				<a href="#language" data-toggle="collapse" data-active="{{ Request::is('control_panel/language*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('language/create') || Request::is('language') || Request::is('language/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('language/create') || Request::is('language') || Request::is('language/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Language</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/language*') ? 'collapse show' : '' }}" id="language" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/language/create') || Request::is('control_panel/language/*/edit') ? 'active' : '' }}">
						<a href="{{route('language.create')}}"> Create Language </a>
					</li>
					<li class="{{ Request::is('control_panel/language') ? 'active' : '' }}">
						<a href="{{route('language.index')}}"> Language Listing  </a>
					</li>                           
				</ul>
			</li>
			<li class="menu">
				<a href="#subject" data-toggle="collapse" data-active="{{ Request::is('control_panel/subject*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('subject/create') || Request::is('subject') || Request::is('subject/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('subject/create') || Request::is('subject') || Request::is('subject/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Subject</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/subject*') ? 'collapse show' : '' }}" id="subject" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/subject/create') || Request::is('control_panel/subject/*/edit') ? 'active' : '' }}">
						<a href="{{route('subject.create')}}"> Create Subject </a>
					</li>
					<li class="{{ Request::is('control_panel/subject') ? 'active' : '' }}">
						<a href="{{route('subject.index')}}"> Subject Listing  </a>
					</li>                           
				</ul>
			</li>
			<li class="menu">
				<a href="#profession" data-toggle="collapse" data-active="{{ Request::is('control_panel/profession*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('profession/create') || Request::is('profession') || Request::is('profession/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('profession/create') || Request::is('profession') || Request::is('profession/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Profession</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/profession*') ? 'collapse show' : '' }}" id="profession" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/profession/create') || Request::is('control_panel/profession/*/edit') ? 'active' : '' }}">
						<a href="{{route('profession.create')}}"> Create Profession </a>
					</li>
					<li class="{{ Request::is('control_panel/profession') ? 'active' : '' }}">
						<a href="{{route('profession.index')}}"> Profession Listing </a>
					</li>                           
				</ul>
			</li>
			<li class="menu">
				<a href="#pages" data-toggle="collapse" data-active="{{ Request::is('control_panel/pages*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('pages/create') || Request::is('pages') || Request::is('pages/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('pages/create') || Request::is('pages') || Request::is('pages/*/edit') ? '' : 'collapsed' }}">
					<div class="">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
						<span>Pages</span>
					</div>
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
					</div>
				</a>
				<ul class="collapse submenu list-unstyled {{ Request::is('control_panel/pages*') ? 'collapse show' : '' }}" id="pages" data-parent="#accordionExample">
					<li class="{{ Request::is('control_panel/pages/create') || Request::is('control_panel/pages/*/edit') ? 'active' : '' }}">
						<a href="{{route('pages.create')}}"> Create Page </a>
					</li>
					<li class="{{ Request::is('control_panel/pages') ? 'active' : '' }}">
						<a href="{{route('pages.index')}}"> Page Listing  </a>
					</li>                           
				</ul>
			</li>

			<li class="menu">
				<a href="{{route('admin.logout')}}"  data-active="{{ Request::is('/') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
					<div class="">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
						<span>Sign Out</span>
					</div>
				</a>
			</li>
		</ul>
	</nav>
</div>
<!--  END SIDEBAR  -->