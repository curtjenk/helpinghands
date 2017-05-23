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
            Join other Legacy Builders as we fellowship together:
        </p>
        <p class="col-md-offset-2">
           <b>{{ $event->subject }}</b>
        </p>
        <h4>Please respond by clicking the appropriate link</h4>
        <p>
            <a href="{{ url('/api/evite/s/'.$event->id."/".$user->id."/".$token) }}">Yes, I'll fellowship with the brothers!</a>
        </p>
        <p>
            <a href="{{ url('/api/evite/o/'.$event->id."/".$user->id."/".$token) }}">Sorry, maybe next time</a>
        </p>
        <h4><u>Fellowship event description</u></h4>
        <p>
            <div>
                <b>{{ $event->date_start}} thru {{ $event->date_end }}</b>
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