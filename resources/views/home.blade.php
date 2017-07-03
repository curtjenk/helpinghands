@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container header">
            <div class=""></div>
        </div>
    </section>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">Dashboard</div> --}}

                <div class="panel-body">
                    How are we doing?
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Left Side Nav
        </div>
        <div class="col-md-9">
            <dashboardcharts></dashboardcharts>
        </div>
    </div>

</div>
@endsection
