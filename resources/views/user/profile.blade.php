@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Member Profile</div>
        </div>
    </section>
  
    <memberprofile
        username="{{ $user->name }}"
    >
    </memberprofile>

</main>

@endsection
