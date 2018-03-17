@extends('layouts.app')

@section('content')
{{-- <main> --}}
    {{-- <section class="page-header">
        <div class="container">
            <div class="pull-left header">Organization</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/organization') }}"><i class="fa fa-list"></i> Organizations</a>
            </div>
        </div>
    </section> --}}
    {{-- <div class="container"> --}}
    <nav-top-2
        title="Organization"
        :links="[{perm:'List organizations', href:'/organization', name:'List', icon:'fa-list'}]"
    ></nav-top-2>
        <organization-manager
            mode0="{{ $mode }}"
            :user0="{{ Auth::user() }}"
            :orgteams0="{{ $organization }}"
            :members0="{{ $members }}"

        ></organization-manager>
    {{-- </div> --}}
{{-- </main> --}}
@endsection
