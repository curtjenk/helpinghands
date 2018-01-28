@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">
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
        :event0="{{ $event }}"
        :attachments0="{{ $attachments }}"
        :organization0="{{ $organization }}"
        :team0="{{ $team }}"
        :user0="{{ Auth::user() }}"
        :statuses0="{{ $statuses }}"
        :eventtypes0="{{ $event_types }}">
        </event-manager>
    </div>
</main>

@endsection
