@extends('admin_panel.layouts.app')

@section('content')

    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" style="margin-top:40px"> 
            <div class="widget-heading col-lg-12">
                <h5 class="">Total Records</h5>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('users.index')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalUsers}}</p>
                            <h5 class="">Users</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('posts.list')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalPosts}}</p>
                            <h5 class="">Post Section</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('videos.list')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalVideos}}</p>
                            <h5 class="">Video Section</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('scholarship.index')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalScholarshipReq}}</p>
                            <h5 class="">Scholarship Request</h5>
                        </div> 
                    </a>
                </div>
            </div>
        </div>
        <div class="row layout-top-spacing" style="margin-top:40px">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('subscription.index')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalSubscriptions}}</p>
                            <h5 class="">Subscriptions</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('withdraw.list')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalWithdrawReq}}</p>
                            <h5 class="">Withdraw Request</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('wallet.index')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalWallet}}</p>
                            <h5 class="">Wallet</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="{{route('contact.index')}}">
                        <div class="widget-heading">
                            <p class="w-value">{{$totalSupportEnq}}</p>
                            <h5 class="">Contacts Query</h5>
                        </div> 
                    </a>
                </div>
            </div>
        </div>

        <!-- <div class="row layout-top-spacing" style="margin-top:40px"> 
            <div class="widget-heading col-lg-12">
                <h5 class="">Current Month Records</h5>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="">
                        <div class="widget-heading">
                            <p class="w-value">0</p>
                            <h5 class="">Customers</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="">
                        <div class="widget-heading">
                            <p class="w-value">0</p>
                            <h5 class="">Query Posts</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="">
                        <div class="widget-heading">
                            <p class="w-value">0</p>
                            <h5 class="">Query Videos</h5>
                        </div> 
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="widget widget-one_hybrid widget-followers" style="height: 95%;">
                    <a href="">
                        <div class="widget-heading">
                            <p class="w-value">0</p>
                            <h5 class="">Mock up Tests</h5>
                        </div> 
                    </a>
                </div>
            </div>
        </div> -->
    </div>
    <div class="footer-wrapper">
        <div class="footer-section f-section-1">
            <p class="">Copyright © {{date('Y')}} <a target="_blank" href="{{url('')}}">{{env('APP_NAME')}}</a>, All rights reserved.</p>
        </div>
    </div>
    
@endsection  