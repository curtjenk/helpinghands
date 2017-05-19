@extends('layouts.email')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Your response is appreciated</div>
            {{-- <div class="pull-right">
                @can ('create-event')
                    <a class="btn btn-default" href="{{ url('/event/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div> --}}
        </div>
    </section>
    <div class="container">
        <h3>Dear {{ $user->name}},</h3>
        <p>
            Thanks for your continued service.<b> {{ $event->organization->name }}</b> needs your help with the
             <b>{{ $event->subject }}</b>.
             <br/>
             See below for more details.
        </p>
        <h4>Please respond by clicking the appropriate link</h4>
        <p>
            <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">Yes, I will help</a>
        </p>
        <p>
            <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">Sorry, maybe next time</a>
        </p>
        <h4><u>Event Description</u></h4>
        <p>
            This is a {{ $event->event_type->name }} event/opportunity.
        </p>
        <p>
            <div>
                <b>{{ $event->date_start}} thru {{ $event->date_end }}</b>.
            </div>
            <div>
                <b>{{ $event->description }}</b>
            </div>
        </p>
    </div>
</main>
@endsection