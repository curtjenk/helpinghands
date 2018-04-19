@extends('layouts.email')

@section('content')
    @php
        $timeStart = json_decode($event->time_start);
        $timeStart = $timeStart->hh.":".$timeStart->mm." ".$timeStart->a;
        $timeEnd = json_decode($event->time_end);
        $timeEnd = $timeEnd->hh.":".$timeEnd->mm." ".$timeEnd->a;
    @endphp
<div class="row mt-6">
    <h3>{{ $user->name}},</h3>
</div>
<div class="row">
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