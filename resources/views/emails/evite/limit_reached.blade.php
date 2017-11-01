@extends('layouts.email')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Confirmation - Yes, I'm going</div>
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
            We're sorry to say the <b>{{ $event->subject }}</b> event has reached the maximum number of signups.
            <br/>
            Please check later as there may be a cancellation.
        </p>
        <p>
            Thanks for your interest and continued support!
        </p>
        <h4><u>Event Description</u></h4>
        <p>
            <div>
                <b>{{ $event->date_start}} thru {{ $event->date_end }}</b>.
            </div>
            <div>
                <pre>
                    <b>{{ $event->description }}</b>
                </pre>
            </div>
        </p>
        <hr />
        @include('layouts.manhood')
    </div>
</main>
@endsection
