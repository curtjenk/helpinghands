@extends('layouts.email')

@section('content')
<main>
    @include('layouts.email_header')
    {{-- <section class="page-header">
        <div class="container">
            <div class="pull-left header">See below to respond</div>
        </div>
    </section> --}}
    <div class="container">
        <h3>Dear {{ $user->name}},</h3>
        <p>
            <b>{{ $event->subject }}</b> is an opportunity to continue to Learn, Train &amp; Grow;
             which is a key component in our journey to be Legacy Builders.
             Will you take advantage of this great opportunity?
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
        <h4><u>Learn, Train, Grow event description</u></h4>
        <p>
            <div>
                <b>{{ $event->date_start}} thru {{ $event->date_end }}</b>.
                <br>
            </div>
            <div>
                <b><pre>
                    {{ $event->description }}
                </pre></b>
            </div>
        </p>
    </div>
    @include('layouts.email_footer')
</main>
@endsection