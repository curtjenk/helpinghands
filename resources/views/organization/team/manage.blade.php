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
    <div class="container">
        <team-manager
            mode0="{{ $mode }}"
            :user0="{{ Auth::user() }}"
            :team0="{{ $team }}"
            :team_members0="{{ $members }}"
            :other_org_members0="{{ $other_org_members }}"

        ></team-manager>
    </div>
</main>
@endsection
