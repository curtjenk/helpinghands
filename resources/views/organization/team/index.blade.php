@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Teams</div>
        </div>
    </section>
    <div class="container-fluid">
        <teamslist
          :is-admin="{{  1 }}"
          :userid="{{ Auth::user()->id }}"
        ></teamslist>
    </div>
</main>

@endsection
