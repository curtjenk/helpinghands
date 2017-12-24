@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Organization</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/organization') }}"><i class="fa fa-list"></i> Organizations</a>
                {{-- @can ('update', $organization)
                <a class="btn btn-default" href="{{ url('/organization/'.$organization->id.'/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                @endcan
                @can ('create-organization')
                <a class="btn btn-default" href="{{ url('/organization/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan --}}
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <organization-manager
            :user0="{{ Auth::user() }}"
            {{-- :orgteams0="{{ $organization }}" --}}
        ></organization-manager>
    </div>
</main>
@endsection
