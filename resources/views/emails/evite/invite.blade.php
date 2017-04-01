@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Your response is appreciated</div>
            {{-- <div class="pull-right">
                @can ('create-ticket')
                    <a class="btn btn-default" href="{{ url('/ticket/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div> --}}
        </div>
    </section>
    <div class="container">
        <h3>Dear {{ $user->name}},</h3>
        <p>
            Thanks for your continued service.<b> {{ $ticket->organization->name }}</b> needs your help with the
             <b>{{ $ticket->subject }}</b>.
             <br/>
             See below for more details.
        </p>
        <h4>Please respond by clicking the appropriate link</h4>
        <p>
            <a href="{{ url('/api/evite/s/'.$ticket->id."/".$user->id."/".$token) }}">Yes, I will help</a>
        </p>
        <p>
            <a href="{{ url('/api/evite/o/'.$ticket->id."/".$user->id."/".$token) }}">Sorry, maybe next time</a>
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