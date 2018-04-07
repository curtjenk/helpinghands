@extends('layouts.app')

@section('content')
<main>

    @php
         $eventid = json_decode($event)->id;
         $signedUp = json_encode(Auth::user()->signedup($eventid,'yes'));
        //  dump($signedUp);
        // die();
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

        {{-- :user="{{ json_encode($userRolesPermissions['user']) }}"
        :roles="{{ json_encode($userRolesPermissions['roles']) }}"
        :permissions="{{ json_encode($userRolesPermissions['permissions']) }}" --}}
    >
    </event-manager>

</main>

@endsection
