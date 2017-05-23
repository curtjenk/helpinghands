@extends('layouts.email')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Your response is appreciated</div>
        </div>
    </section>
    <div class="container">
        <h3>Dear {{ $user->name}},</h3>
        <p>
            Please accept this opportunity to participate with "<b>{{ $event->subject }}</b>"
            <br/>
        </p>
        <h4>Please respond by clicking the appropriate link</h4>
        <p>
            <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">Yes, I will participate</a>
        </p>
        <p>
            <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">Sorry, maybe next time</a>
        </p>
        <h4><u>Service Opportunity Description</u></h4>
        <p>
            <div>
                <b>{{ $event->date_start}} thru {{ $event->date_end }}</b>.
            </div>
            <br/>
            <div>
                <b>{{ $event->description }}</b>
            </div>
        </p>
        <hr />
        @include('layouts.manhood')
    </div>
</main>
@endsection