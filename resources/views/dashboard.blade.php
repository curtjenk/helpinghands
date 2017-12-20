@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container header">
            <div class=""></div>
        </div>
    </section>
    <div class="">
        <dashboardcharts
             :userid="{{ Auth::user()->id }}"
        ></dashboardcharts>
    </div>
@endsection
