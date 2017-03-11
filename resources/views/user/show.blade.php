@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-right header">
                <a class="btn btn-default" href="{{ url('/user') }}"><i class="fa fa-users"></i> Users</a>
                @can ('update', $user)
                <a class="btn btn-default" href="{{ url('/user/'.$user->id.'/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                @endcan
            </div>
        </div>
    </section>
    <div class="container">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>User Information</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>
                            <div class="col-md-8">
                                <p id="email" class="form-control-static">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-8">
                                <p id="name" class="form-control-static">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="homephone" class="col-md-4 control-label">Home Phone</label>
                            <div class="col-md-8">
                                <p id="homephone" class="form-control-static">{{ $user->homephone }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobilephone" class="col-md-4 control-label">Mobile Phone</label>
                            <div class="col-md-8">
                                <p id="mobilephone" class="form-control-static">{{ $user->mobilephone }}</p>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="role" class="col-md-4 control-label">Role</label>
                            <div class="col-md-8">
                                <p id="role" class="form-control-static">{{ $user->role->name}}</p>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</main>
@endsection
