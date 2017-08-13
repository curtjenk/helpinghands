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
          Regarding {{ $event->subject }}:
        </p>
        <br/>
        <p>
            &nbsp;&nbsp;{{ $content }}
        </p>
        <hr/>
        @include('layouts.email_footer')
    </div>
</main>
@endsection