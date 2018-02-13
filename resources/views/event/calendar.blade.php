@extends('layouts.app')

@section('content')
<main>
    <nav-top-2
        title="Events Calendar"
        :user="{{ json_encode($userRolesPermissions['user']) }}"
        :roles="{{ json_encode($userRolesPermissions['roles']) }}"
        :permissions="{{ json_encode($userRolesPermissions['permissions']) }}"
        :links="[{perm:'List events', href:'/event', name:'Events', icon:'fa-list'},
                 {perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]"
    ></nav-top-2>
    <input type="hidden" name="eventdates" value="{{ $events }}">
    <div class="container">
        <div class="col-md-2">
            <p class="text-center">
                Count Of Events Per Month
            </p>
            <table class="table">
                <thead>
                    <tr><td>Year/Month</td><td>Events</td></tr>
                </thead>
                <tbody>
                    @foreach ($counts as $count)
                        <tr>
                            <td class="col-md-8">
                                {{ $count->interval }}
                            </td>
                            <td class="col-md-4">
                                {{ $count->num }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-8">
    	    <div id="calendar"></div>
        </div>
    </div>
</main>
@endsection
