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
    <div class="container-fluid">
        <event-manager
        mode0="{{ $mode }}"
        :user0="{{ Auth::user() }}"
        :statues0="{{ $statuses }}"
        :eventTypes0="{{ $eventTypes }}"
        ></event-manager>
    </div>
</main>

@endsection
