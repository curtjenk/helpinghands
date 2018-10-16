@extends('layouts.email')

@section('content')
<main>
    @include('layouts.email_header')
    <div class="container">
        <h3>Dear {{ $user->name}},</h3>
        <p>
        @if(isset($team))
            {{ $organization }} Team: {{ $team }} presents another {{ $event->type }} opportunity!
        @else
            {{ $organization }} presents another {{ $event->type }} opportunity!
        @endif
        </p>
        <br />
        <h3><u>Event Details</u></h3>
        <p>
            <p>
               <strong>{{ $event->subject }}</strong>
            </p>
            <br/>
            <div>
                <b>{{ $event->date_start}} through {{ $event->date_end }}</b>
            </div>
            <br/>
            <div>
                <b><pre>{!! $event->description !!}</pre></b>
            </div>
        </p>
        <br />
        <h4>Please respond by clicking the appropriate link</h4>
        <p>
            <div>
                Click <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">here</a> if you will attend/participate
            </div>
            <div>
                <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">Yes, I will attend/participate</a>
            </div>
        </p>
        <p>
            <div>
                Click <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">here</a> if you will NOT attend/participate
            </div>
            <div>
                <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">Sorry, maybe next time</a>
            </div>
        </p>
    </div>
    @include('layouts.email_footer')
</main>
@endsection