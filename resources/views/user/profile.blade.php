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
        avatar0="{{ asset($user->avatar_filename) }}"
    >
    </member-profile>



@endsection
