@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Confirmation - No, maybe next time</div>
            {{-- <div class="pull-right">
                @can ('create-event')
                    <a class="btn btn-default" href="{{ url('/event/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div> --}}
        </div>
    </section>
    <div class="container">
        <h3>{{ $user->name}},</h3>
        <p>
            Thanks for your response and sorry you can't join us this time.
            <br/>
            You will continue to be notified for future events.
            <br/>
            See below for more information regarding the <b>{{ $event->subject }}</b>
        </p>
        <p>
            See you soon!
        </p>
        <h4><u>Event Description</u></h4>
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