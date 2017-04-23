@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Service / Fellowship Events Calendar</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/event') }}"><i class="fa fa-list"></i> Events</a>
                @can ('create-event')
                <a class="btn btn-default" href="{{ url('/event/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div>
        </div>
    </section>
    <input type="hidden" name="eventdates" value="{{ $events }}">
    <div class="container">
        <div class="col-md-2">
            <p class="text-center">
                Three Month Preview
            </p>
            <table class="table">
                <thead>
                    <tr><td>Year/Month</td><td>Events</td></tr>
                </thead>
                <tbody>
                    @foreach ($counts as $count)
                        <tr>
                            <td class="col-md-8">
                                {{ $count->interval }}
                            </td>
                            <td class="col-md-4">
                                {{ $count->num }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-9">
    	    <div id="calendar"></div>
        </div>
    </div>
</main>
@endsection
