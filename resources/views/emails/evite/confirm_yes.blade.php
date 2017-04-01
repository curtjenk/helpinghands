@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Confirmation - Yes, I'm going</div>
            {{-- <div class="pull-right">
                @can ('create-ticket')
                    <a class="btn btn-default" href="{{ url('/ticket/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div> --}}
        </div>
    </section>
    <div class="container">
        <h3>{{ $user->name}},</h3>
        <p>
            We appreciate your time and talents.
            <br/>
            See below for more information regarding <b>{{ $ticket->subject }}</b> 
        </p>
        <p>
            Please add the date(s) to your calendar.
        </p>
        <p>
            Thanks again for your commitment!
        </p>
        <h4><u>Event Description</u></h4>
        <p>
            <div>
                <b>{{ $ticket->date_start}} thru {{ $ticket->date_end }}</b>.
            </div>
            <div>
                <b>{{ $ticket->description }}</b>
            </div>
        </p>
    </div>
</main>
@endsection
