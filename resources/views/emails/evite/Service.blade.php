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
        <h4><u>Service Opportunity Description</u></h4>
        <p>
            <div>
                <b>{{ $event->date_start}} thru {{ $event->date_end }}</b>.
            </div>
            <br/>
            <div>
                <pre>
                    <b>{{ $event->description }}</b>
                </pre>
            </div>
        </p>
    </div>
    @include('layouts.email_footer')
</main>
@endsection