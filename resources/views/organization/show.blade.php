@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Organization</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/organization') }}"><i class="fa fa-list"></i> Organizations</a>
                @can ('update', $organization)
                <a class="btn btn-default" href="{{ url('/organization/'.$organization->id.'/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                @endcan
                @can ('create-organization')
                <a class="btn btn-default" href="{{ url('/organization/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div>
        </div>
    </section>
    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Organization</label>
                            <div class="col-md-8">
                                <p id="name" class="form-control-static">
                                    {{$organization->name}}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Phone</label>
                            <div class="col-md-8">
                                <p id="phone" class="form-control-static">{{ $organization->phone }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address1" class="col-md-4 control-label">Address 1</label>
                            <div class="col-md-8">
                                <p id="address1" class="form-control-static">{{ $organization->address1 }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address2" class="col-md-4 control-label">Address 2</label>
                            <div class="col-md-8">
                                <p id="address2" class="form-control-static">{{ $organization->address2 }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-4 control-label">City</label>
                            <div class="col-md-8">
                                <p id="city" class="form-control-static">{{ $organization->city }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-md-4 control-label">State</label>
                            <div class="col-md-8">
                                <p id="state" class="form-control-static">{{ $organization->state }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zipcode" class="col-md-4 control-label">Zip Code</label>
                            <div class="col-md-8">
                                <p id="zipcode" class="form-control-static">{{ $organization->zipcode }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</main>
@endsection
