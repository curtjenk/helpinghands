@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left pageHeader testFont">Create User</div>
        </div>
    </section>
    <div class="container testFont">
        <form class="form-horizontal" method="POST" action="{{ url('/user') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Email</label>
                <div class="col-md-8">
                    <input id="email" type="text" class="editInfo" name="email" autofocus maxlength="255" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <hr />
            <div class="form-group{{ $errors->has('prefix') ? ' has-error' : '' }}">
                <label for="prefix" class="col-md-4 control-label">Prefix</label>
                <div class="col-md-8">
                    <input id="prefix" type="text" class="editInfo" name="prefix" maxlength="255" value="{{ old('prefix') }}">
                    @if ($errors->has('prefix'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prefix') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                <label for="firstname" class="col-md-4 control-label">First name</label>
                <div class="col-md-8">
                    <input id="firstname" type="text" class="editInfo" name="firstname" maxlength="255" value="{{ old('firstname') }}" required>
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('middlename') ? ' has-error' : '' }}">
                <label for="middlename" class="col-md-4 control-label">Middle name</label>
                <div class="col-md-8">
                    <input id="middlename" type="text" class="editInfo" name="middlename" maxlength="255" value="{{ old('middlename') }}">
                    @if ($errors->has('middlename'))
                        <span class="help-block">
                            <strong>{{ $errors->first('middlename') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                <label for="lastname" class="col-md-4 control-label">Last name</label>
                <div class="col-md-8">
                    <input id="lastname" type="text" class="editInfo" name="lastname" maxlength="255" value="{{ old('lastname') }}" required>
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->last('lastname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('suffix') ? ' has-error' : '' }}">
                <label for="suffix" class="col-md-4 control-label">Suffix</label>
                <div class="col-md-8">
                    <input id="suffix" type="text" class="editInfo" name="suffix" maxlength="255" value="{{ old('suffix') }}">
                    @if ($errors->has('suffix'))
                        <span class="help-block">
                            <strong>{{ $errors->first('suffix') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <hr />
            <div class="form-group{{ $errors->has('cellphone') ? ' has-error' : '' }}">
                <label for="cellphone" class="col-md-4 control-label">Cellphone</label>
                <div class="col-md-8">
                    <input id="cellphone" type="text" class="editInfo" name="cellphone" maxlength="64" value="{{ old('cellphone') }}" required>
                    @if ($errors->has('cellphone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cellphone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                <div class="col-md-4 text-right">
                    <label class="control-label">Role</label>
                    @if ($errors->has('role_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('role_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-8">
                    @foreach ($roles as $role)
                        <div class="radio">
                            <label>
                                <input type="radio" name="role_id" value="{{ $role->id }}"> {{$role->name}}
                            </label>
                        </div>
                    @endforeach
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
