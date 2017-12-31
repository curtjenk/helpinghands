@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Create an Organization</div>
        </div>
    </section>
    <div class="container">

            @if(isset($organization))
        <form class="form-horizontal" method="POST" action="{{ url('/organization/'.$organization->id) }}">
            <input name="_method" type="hidden" value="PUT">
            @else
        <form class="form-horizontal" method="POST" action="{{ url('/organization') }}">
            @endif
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>
                <div class="col-md-5">
                    <input required id="name" type="text" class="editInfo" name="name" autofocus maxlength="255" value="{{ isset($organization) ? $organization->name : old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-4 control-label">Phone</label>
                <div class="col-md-2">
                    <input required id="phone" type="text" class="editInfo" name="phone" maxlength="255" value="{{ isset($organization) ? $organization->phone : old('phone') }}">
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                <label for="address1" class="col-md-4 control-label">Address 1</label>
                <div class="col-md-5">
                    <input required id="address1" type="text" class="editInfo" name="address1" maxlength="255" value="{{ isset($organization) ? $organization->address1 : old('address1') }}">
                    @if ($errors->has('address1'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address1') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                <label for="address2" class="col-md-4 control-label">Address 2</label>
                <div class="col-md-5">
                    <input id="address2" type="text" class="editInfo" name="address2" maxlength="255" value="{{ isset($organization) ? $organization->address2 : old('address2') }}">
                    @if ($errors->has('address2'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address2') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                <label for="city" class="col-md-4 control-label">City</label>
                <div class="col-md-3">
                    <input required id="city" type="text" class="editInfo" name="city" maxlength="255" value="{{ isset($organization) ? $organization->city : old('city') }}">
                    @if ($errors->has('city'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                <label for="state" class="col-md-4 control-label">State</label>
                <div class="col-md-2">
                    <input required id="state" type="text" class="editInfo" name="state" maxlength="80" value="{{ isset($organization) ? $organization->state : old('state') }}">
                    @if ($errors->has('state'))
                        <span class="help-block">
                            <strong>{{ $errors->first('state') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                <label for="zipcode" class="col-md-4 control-label">Zip Code</label>
                <div class="col-md-2">
                    <input required id="zipcode" type="text" class="editInfo" name="zipcode" maxlength="40" value="{{ isset($organization) ? $organization->zipcode : old('zipcode') }}">
                    @if ($errors->has('zipcode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('zipcode') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <hr />
            <div class="block text-center">
                <a class="btn btn-default" href="{{ Request::header('referer') }}">
                    <i class="fa fa-btn fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary" name="submit">
                    <i class="fa fa-btn fa-check"></i> Accept
                </button>
            </div>
        </form>
    </div>
</main>

@endsection
