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
                <a href="{{route('users.index')}}" data-active="{{ Request::is('control_panel/users') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Users</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="#subjects" data-toggle="collapse" data-active="{{ Request::is('control_panel/subjects*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('subjects/create') || Request::is('subjects') || Request::is('subjects/*/edit') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('subjects/create') || Request::is('subjects') || Request::is('subjects/*/edit') ? '' : 'collapsed' }}">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Subjects</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('control_panel/subjects*') ? 'collapse show' : '' }}" id="subjects" data-parent="#accordionExample">
                    <li class="{{ Request::is('control_panel/subjects/create') || Request::is('control_panel/subjects/*/edit') ? 'active' : '' }}">
                        <a href="{{route('subjects.create')}}"> Create Subject </a>
                    </li>
                    <li class="{{ Request::is('control_panel/subjects') ? 'active' : '' }}">
                        <a href="{{route('subjects.index')}}"> Subjects Listing  </a>
                    </li>                           
                </ul>
            </li>
            <li class="menu">
                <a href="{{route('post.list')}}" data-active="{{ Request::is('control_panel/post_list') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Manage Post</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a href="#banner" data-toggle="collapse" data-active="{{ Request::is('control_panel/banner*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('control_panel/banner*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('control_panel/banner*') ? '' : 'collapsed' }}">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span>Manage Banner</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('control_panel/banner*') ? 'collapse show' : '' }}" id="banner" data-parent="#accordionExample">
                    <li class="{{ Request::is('control_panel/banner') ? 'active' : '' }}">
                        <a href="{{route('banner.index')}}"> Banner Listing  </a>
                    </li>                           
                </ul>
            </li>
            <li class="menu">
                <a href="#support" data-toggle="collapse" data-active="{{ Request::is('control_panel/support*') ? 'true' : 'false' }}" aria-expanded="{{ Request::is('category/support.*') ? 'true' : 'false' }}" class="dropdown-toggle {{ Request::is('category/create') || Request::is('category') || Request::is('category/*/edit') ? '' : 'collapsed' }}">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Manage Support</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('control_panel/support*') ? 'collapse show' : '' }}" id="support" data-parent="#accordionExample">
                    <li class="{{ Request::is('control_panel/support/create') || Request::is('control_panel/support/*/edit') ? 'active' : '' }}">
                        <a href="{{route('support.create')}}"> Create Support </a>
                    </li>
                    <li class="{{ Request::is('control_panel/support') ? 'active' : '' }}">
                        <a href="{{route('support.index')}}"> Support Listing  </a>
                    </li>                           
                </ul>
            </li>
            <li class="menu">
                <a href="{{route('change.password')}}"  data-active="{{ Request::is('control_panel/change_password') ? 'true' : 'false' }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                        <span>Change Password</span>
                    </div>
                </a>
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