@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Team</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/team') }}"><i class="fa fa-list"></i> Teams</a>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <team-manager
            mode0="{{ $mode }}"
            :user0="{{ Auth::user() }}"
            :team0="{{ $team }}"
            :orgmembers0="{{ $members }}"
        ></team-manager>
    </div>
</main>
@endsection
