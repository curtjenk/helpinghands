@extends('layouts.email')

@section('content')
    @php
        $timeStart = json_decode($event->time_start);
        $hh = empty($timeStart->hh) ? "" : $timeStart->hh;
        $mm = empty($timeStart->mm) ? "" : $timeStart->mm;
        $a = empty($timeStart->a) ? "" : $timeStart->a;
        $timeStart =  $hh.":".$mm." ".$a;

        $timeEnd = json_decode($event->time_end);
        $hh = empty($timeEnd->hh) ? "" : $timeEnd->hh;
        $mm = empty($timeEnd->mm) ? "" : $timeEnd->mm;
        $a = empty($timeEnd->a) ? "" : $timeEnd->a;
        $timeEnd =  $hh.":".$mm." ".$a;

    @endphp
<div class="row mt-6">
    <h1>Confirmation - Yes, I'm going</h1>
</div>
<hr />
<div class="row">
    <h3>{{ $user->name}},</h3>
</div>
<div class="row">
    <p>
        We appreciate your time and talents.
        <br/>
        You signed up for: <b style="color:red;">{{ $event->subject }}</b>
    </p>
</div>
<div class="row">
    <p>
        Please add the date(s) to your calendar.
    </p>
    <p>
        Thanks again for your commitment!
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
