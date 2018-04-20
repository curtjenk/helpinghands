@extends('layouts.email')

@section('content')
    @php
        $timeStart = json_decode($event->time_start);
        $timeStart = $timeStart->hh.":".$timeStart->mm." ".$timeStart->a;
        $timeEnd = json_decode($event->time_end);
        $timeEnd = $timeEnd->hh.":".$timeEnd->mm." ".$timeEnd->a;
    @endphp
<div class="row mt-6">
    <h1>Confirmation - <u>No, I'm Not participating</u></h1>
</div>
<div class="row">
    <h3>{{ $user->name}},</h3>
</div>
<div class="row">
    <div class="col-md-11 offset-md-1">
        <p>
        Thanks for your response and sorry you can't join us this time.
        <br/>
        You will continue to be notified for future events.
        <br/>
        See below for more information regarding <b style="color:red;">{{ $event->subject }}</b>
        </p>
    </div>
    <div class="col-12">
        <p>
            See you soon!
        </p>
    </div>
</div>
<div class="row">
    <h4><u>Event Description</u></h4>
</div>
<div class="row">
        <b>{{ $event->date_start}} thru {{ $event->date_end }}</b>
</div>
<div class="row">
    <b>{{ $timeStart }}</b>
</div>
<div class="row">
    <p>
        <b>{{ $event->description_text }}</b>
    </p>
</div>

@endsection