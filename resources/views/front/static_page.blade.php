@extends('front.layouts.app')

@section('content')

    <div class="container">
        <h1>{{$record_data->page_title}}</h1>
        {!!$record_data->page_details!!}
    </div>
    
@endsection  