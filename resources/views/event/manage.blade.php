@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">
                @if(isset($event)) Edit
                @else Create
                @endif
                Event
            </div>
            <div class="pull-left">
            </div>
        </div>
    </section>
    @php
        // dump($event_types);
        // $org = Auth::user()->organization;
        // if (Request::session()->has('orgid')) {
        //    $org = App\Organization::find(Request::session()->get('orgid'));
        // }
    @endphp
    <div class="container-fluid">
        <event-manager
        mode0="{{ $mode }}"
        :user0="{{ Auth::user() }}"
        :statuses0="{{ json_encode($statuses) }}"
        :eventtypes0="{{ json_encode($event_types) }}">
        </event-manager>
    </div>
</main>

@endsection
