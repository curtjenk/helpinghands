@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Service / Fellowship Events Calendar</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/ticket') }}"><i class="fa fa-list"></i> Events</a>
                @can ('create-ticket')
                <a class="btn btn-default" href="{{ url('/ticket/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div>
        </div>
    </section>
    <input type="hidden" name="eventdates" value="{{ $tickets }}">
    <div class="container">
    	<div id="calendar"></div>
    </div>
</main>
@endsection
