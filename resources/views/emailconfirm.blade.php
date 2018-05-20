@extends('layouts.email')

@section('content')
    <div class="page-header mx-auto" style="width:60%;">
        <div class="card">
            <div class="card-header">Registration Confirmed</div>
            <div class="card-body">
                Your Email is successfully verified. Click here to <a href="{{ url('/login') }}">login</a>
            </div>
        </div>
    </div>
@endsection