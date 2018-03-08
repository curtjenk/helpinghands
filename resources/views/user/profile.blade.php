@extends('layouts.app')

@section('content')

    {{-- <section class="page-header">
        <div class="container">
            <div class="pull-left header">Member Profile</div>
        </div>
    </section> --}}

    <member-profile
        :user0="{{ $user }}"
        :orgteams0="{{ $orgteams }}"
        avatar0="{{ $user->avatar_filename ? asset($user->avatar_filename) : null }}"
    >
    </member-profile>



@endsection
