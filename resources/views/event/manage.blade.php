@extends('layouts.app')

@section('content')
<main>

    @php
        if (isset($event) && $event != 'null') {
            $eventid = json_decode($event)->id;
            $signedUp = json_encode(Auth::user()->signedup($eventid,'yes'));
        } else {
            $signedUp = json_encode(null);
        }
    @endphp

    <event-manager
        :authorizations="{{ $authorizations }}"
        mode0="{{ $mode }}"
        :event0="{{ $event }}"
        :attachments0="{{ $attachments }}"
        :organization0="{{ $organization }}"
        :team0="{{ $team }}"
        :user0="{{ Auth::user() }}"
        :statuses0="{{ $statuses }}"
        :eventtypes0="{{ $event_types }}"
        :signed-up0="{{ $signedUp }}"
    >
    </event-manager>

</main>

@endsection
