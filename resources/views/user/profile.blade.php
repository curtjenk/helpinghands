@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Member Profile</div>
        </div>
    </section>

    <memberprofile
        :user0="{{ $user }}"
        :userorgs0="{{ $userorgs }}"
        :userteams0="{{ $userteams }}"
        :orgteams0="{{ $orgteams }}"
        avatar0="{{ asset($user->avatar_filename) }}"
    >
    </memberprofile>

</main>

@endsection
