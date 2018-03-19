@extends('layouts.app')

@section('content')

    <nav-top-2
        title="Team"
        :links="[{perm:'List teams', href:'/team', name:'List', icon:'fa-list'}]"
    ></nav-top-2>
    <team-manager
        mode0="{{ $mode }}"
        :user0="{{ Auth::user() }}"
        :team0="{{ $team }}"
        :team_members0="{{ $members }}"
        :other_org_members0="{{ $other_org_members }}"
    ></team-manager>
    
@endsection
