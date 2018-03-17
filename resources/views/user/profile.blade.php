@extends('layouts.app')

@section('content')

    <nav-top-2
        title="My Profile"
        {{-- :user="{{ json_encode($userRolesPermissions['user']) }}"
        :roles="{{ json_encode($userRolesPermissions['roles']) }}"
        :permissions="{{ json_encode($userRolesPermissions['permissions']) }}" --}}
        {{-- :links="[{perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]" --}}
    ></nav-top-2>

    <member-profile
        :user0="{{ $user }}"
        :orgteams0="{{ $orgteams }}"
        avatar0="{{ $user->avatar_filename ? asset($user->avatar_filename) : null }}"
    >
    </member-profile>



@endsection
