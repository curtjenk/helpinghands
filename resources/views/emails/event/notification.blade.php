@extends('layouts.email')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
        </div>
    </section>
    <div class="container">
        <h4><b>Hello {{ $notify_user->name }},</b></h4>
        <p>
          Here's a message/note regarding {{ $event->subject }}:
            <br/>
            {{ $content }}
        </p>
        <hr/>
        @include('layouts.manhood')
    </div>
</main>
@endsection