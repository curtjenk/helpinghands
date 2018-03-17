@extends('layouts.app')

@section('content')
    <nav-top-2
        title="Dashboard"
        {{-- :user="{{ json_encode($userRolesPermissions['user']) }}"
        :roles="{{ json_encode($userRolesPermissions['roles']) }}"
        :permissions="{{ json_encode($userRolesPermissions['permissions']) }}" --}}
        {{-- :links="[{perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]" --}}
    ></nav-top-2>
    <dashboardcharts
     :userid="{{ Auth::user()->id }}"
    ></dashboardcharts>
@endsection
