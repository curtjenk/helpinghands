@extends('layouts.app')

@section('content')
    <nav-top-2
        title="Administrator Menu"
        :user="{{ json_encode($userRolesPermissions['user']) }}"
        :roles="{{ json_encode($userRolesPermissions['roles']) }}"
        :permissions="{{ json_encode($userRolesPermissions['permissions']) }}"
        {{-- :links="[{perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]" --}}
    ></nav-top-2>
    <div class="container">
        @can ('manage-organization')
        <div class="row">
            <div class="mx-auto text-center">
                <a href="{{ url('/organization') }}" name="manage_orgs" style="text-decoration: none;">
                    <i class="fa fa-sitemap fa-5x adminIcons"></i>
                    <p class="">Manage Organizations</p>
                </a>
            </div>
        </div>
        @endcan
        @can ('manage-team')
        <div class="row">
            <div class="mx-auto text-center">
                <a href="{{ url('/team') }}" name="manage_orgs" style="text-decoration: none;">
                    <div class="">
                        <i class="fa fa-sitemap fa-5x adminIcons"></i>
                    </div>
                    <i class="fa fa-sitemap fa-2x adminIcons"></i>
                    <i class="fa fa-sitemap fa-2x adminIcons"></i>
                    <i class="fa fa-sitemap fa-2x adminIcons"></i>
                    <p class="">Manage teams</p>
                </a>
            </div>
        </div>
        @endcan
    </div>

@endsection
