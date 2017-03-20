@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Create User</div>
        </div>
    </section>
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ url('/user') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Email</label>
                <div class="col-md-8">
                    <input required id="email" type="text" class="editInfo" name="email" autofocus maxlength="255" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>
                <div class="col-md-8">
                    <input required id="name" type="text" class="editInfo" name="name" maxlength="255" value="{{ isset($user) ? $user->name : old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('homephone') ? ' has-error' : '' }}">
                <label for="homephone" class="col-md-4 control-label">Home Phone</label>
                <div class="col-md-8">
                    <input id="homephone" type="text" class="editInfo" name="homephone" maxlength="64" value="{{ isset($user) ? $user->homephone : old('homephone') }}">
                    @if ($errors->has('homephone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('homephone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('mobilephone') ? ' has-error' : '' }}">
                <label for="mobilephone" class="col-md-4 control-label">Mobile Phone</label>
                <div class="col-md-8">
                    <input id="mobilephone" type="text" class="editInfo" name="mobilephone" maxlength="64" value="{{ isset($user) ? $user->mobilephone : old('mobilephone') }}">
                    @if ($errors->has('mobilephone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mobilephone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('org_id') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Organization</label>
                <div class="col-md-8">
                    <select id="organization_id" name="organization_id">
                        @foreach ($orgs as $org)
                            <option value="{{ $org->id }}"> {{$org->name}} {{$org->city}} {{$org->state}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('org_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('org_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Role</label>
                <div class="col-md-8">
                    <select id="role_id" name="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"> {{$role->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('role_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role_id') }}</strong>
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
