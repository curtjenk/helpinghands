@extends('layouts.app')

@section('content')
<main>

    @php
        // dump($event_types);
        // $org = Auth::user()->organization;
        // if (Request::session()->has('orgid')) {
        //    $org = App\Organization::find(Request::session()->get('orgid'));
        // }
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

        {{-- :user="{{ json_encode($userRolesPermissions['user']) }}"
        :roles="{{ json_encode($userRolesPermissions['roles']) }}"
        :permissions="{{ json_encode($userRolesPermissions['permissions']) }}" --}}
    >
    </event-manager>

</main>

@endsection
