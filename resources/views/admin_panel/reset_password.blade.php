@extends('layouts.app')

@section('content')
    <div class="common-banner" style="background-image: url('{{asset('images/banner-img-2.png')}}');">
         <h1>Login</h1>
    </div>
    <div class="section section-padding">
        <div class="container">
            <form class="user-form" action="{{route('reset.password.post')}}" method="POST" id="general_form">
                @csrf
                <input type="hidden" name="token" value={{$token}}>
                @if(Session::has('Failed'))
                  <div class="alert alert-danger" role="alert">
                    <strong>Failed ! </strong> {{Session::get('Failed')}}
                  </div>
                @endif
                @if(Session::has('Success'))
                  <div class="alert alert-success" role="alert">
                    <strong>Success ! </strong> {{Session::get('Success')}}
                  </div>
                @endif
                <h3 class="para-family heading-bottom text-center">Reset Password</h3>
                <div class="form-group">
                    <input type="password" maxlength="16" class="form-control basic @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                    @error('password') <div class="invalid-feedback"><span>{{$errors->first('password')}}</span></div>@enderror
                </div>
                <div class="form-group">
                  <input type="password" maxlength="16" class="form-control basic @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Confirm Password" required>
                  @error('confirm_password') <div class="invalid-feedback"><span>{{$errors->first('confirm_password')}}</span></div>@enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn red-btn">Reset Password</button>
                </div>
              </form>
        </div>
    </div>
@endsection
