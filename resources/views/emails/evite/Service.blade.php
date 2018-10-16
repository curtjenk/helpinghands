@extends('layouts.email')

@section('content')
    @php
        $timeStart = json_decode($event->time_start);
        $timeStart = $timeStart->hh.":".$timeStart->mm." ".$timeStart->a;
        $timeEnd = json_decode($event->time_end);
        $timeEnd = $timeEnd->hh.":".$timeEnd->mm." ".$timeEnd->a;
    @endphp
<main>
    @include('layouts.email_header')
    <div class="container">
        <h3>Dear {{ $user->name}},</h3>
        <p>
            Please, accept this opportunity to participate with "<b>{{ $event->subject }}</b>"
            <br/>
        </p>
        <h4>Please respond by clicking the appropriate link</h4>
        <p>
            <div>
                Click <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">here</a> if you will participate
            </div>
            <div>
                <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">Yes, I will participate</a>
            </div>
        </p>
        <p>
            <div>
                Click <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">here</a> if you will NOT participate
            </div>
            <div>
                <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">Sorry, maybe next time</a>
            </div>
        </p>
        <h3><u>Service Opportunity Description</u></h3>
        <p>
            <div>
                <b>{{ $event->date_start @ $timeStart }} thru {{ $event->date_end @ $timeEnd}}</b>
            </div>
            <br/>
            <div>
                <b>{!! $event->description !!}</b>
            </div>
            <br/>
        </br/>
        </p>
    </div>
    @include('layouts.email_footer')
</main>
@endsection