@extends('layouts.app')

@section('content')

    <nav-top-2
        title="My Profile"
    ></nav-top-2>

    <member-profile
        :user0="{{ $user }}"
        :orgteams0="{{ $orgteams }}"
        avatar0="{{ $user->avatar_filename ? asset($user->avatar_filename) : null }}"
    >
    </member-profile>



@endsection
