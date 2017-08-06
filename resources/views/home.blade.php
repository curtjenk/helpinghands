@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container header">
            <div class=""></div>
        </div>
    </section>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h1>How are we doing?</h1>
                    @include('layouts.org_selector')
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <dashboardcharts></dashboardcharts>
        </div>
    </div>

</div>
@endsection
