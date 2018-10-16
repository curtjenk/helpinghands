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
            Join other Legacy Builders as we fellowship together:
        </p>
        <p class="col-md-offset-2">
           <b>{{ $event->subject }}</b>
        </p>
        <h4>Please respond by clicking the appropriate link</h4>
        <p>
            <div>
                Click <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">here</a> if you will attend
            </div>
            <div>
                <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">Yes, I'll fellowship with the brothers!</a>
            </div>
        </p>
        <p>
            <div>
                Click <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">here</a> if you will NOT attend
            </div>
            <div>
                <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">Sorry, maybe next time</a>
            </div>
        </p>
        <h3><u>Fellowship event description</u></h3>
        <p>
            <div>
                <b>{{ $event->date_start @ $timeStart }} thru {{ $event->date_end @ $timeEnd}}</b>
            </div>
            <br/>
            <div>
                <b>{!! $event->description !!}</b>
            </div>
            <br/>
        </p>
    </div>
    @include('layouts.email_footer')
</main>
@endsection