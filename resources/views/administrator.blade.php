@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container header">
            <div class="">Administrator Menu</div>
        </div>
    </section>
    <div class="container">
        <div class="text-center">
            <div class="row">
            {{-- @can ('list-users')
                <div class="col-md-6 col-md-offset-3">
                    <a href="{{ url('/user') }}" name="manage_users" style="text-decoration: none;">
                        <div class="thumbnail">
                            <i class="fa fa-users fa-5x adminIcons"></i>
                            <p class="">Manage Users</p>
                        </div>
                    </a>
                </div>
            @endcan --}}
            </div>
            <div class="row">
            @can ('list-organizations')
                <div class="col-md-6 col-md-offset-3">
                    <a href="{{ url('/organization') }}" name="manage_orgs" style="text-decoration: none;">
                        {{-- <div> --}}
                        <div class="thumbnail">
                            <i class="fa fa-sitemap fa-5x adminIcons"></i>
                            <p class="">Manage Organizations</p>
                        </div>
                    </a>
                </div>
            @endcan
            </div>
        </div>
    </div>
</main>
@endsection
