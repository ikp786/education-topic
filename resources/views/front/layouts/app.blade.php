<!doctype html>
<html>
<head>
    <title>{{$title}} | Topic and Doubts</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('public/images/favicon.png')}}"/>
    @include('front.inc.styles')
</head>
<body>

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    {{--@include('front.inc.header')--}}

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN CONTENT PART  -->
        <div id="content1" class="main-content">

            @yield('content')
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->
    @include('front.inc.footer')

    @include('front.inc.scripts')

</body>
</html>
