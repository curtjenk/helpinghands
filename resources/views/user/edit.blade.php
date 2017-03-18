@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">{{ isset($user) ? 'Update' : 'Create' }} User</div>
        </div>
    </section>
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ url('/user/'.$user->id) }}">
            <input name="_method" type="hidden" value="PUT">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email" class="col-md-4 control-label">Email</label>
                <div class="col-md-8">
                    <p id="email" class="form-control-static">{{ $user->email }}</p>
                </div>
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>
                <div class="col-md-8">
                    <input id="name" type="text" class="editInfo" name="name" maxlength="255" value="{{ isset($user) ? $user->name : old('name') }}" required>
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
                <div class="col-md-4 text-right">
                    <label class="control-label">Organization</label>
                    @if ($errors->has('org_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('org_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-8">
                    <select id="org_id" name="org_id">
                        @foreach ($orgs as $org)
                            <option {{ $user->organization_id==$org->id ? 'selected' : '' }} value="{{ $org->id }}"> {{$org->name}} {{$org->city}} {{$org->state}}</option>
                        @endforeach
                    </select>
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
                    <select id="role_id" name="role_id">
                        @foreach ($roles as $role)
                            <option {{ $user->role_id==$role->id ? 'selected' : '' }} value="{{ $role->id }}"> {{$role->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr />
            {{-- {{ var_dump($user) }} --}}
            <div class="form-group{{ $errors->has('opt_receive_evite') ? ' has-error' : '' }}">
                <label class="control-label col-md-4 text-right">Receive Evites</label>
                <div class="col-md-8">
                    <input type="checkbox" name="opt_receive_evite"
                        {{ $user->opt_receive_evite==true ? ' checked' : ''}}
                        data-size="mini">
                    @if ($errors->has('opt_receive_evite'))
                        <span class="help-block">
                            <strong>{{ $errors->first('opt_receive_evite') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('opt_show_mobilephone') ? ' has-error' : '' }}">
                <label class="control-label col-md-4 text-right">Show Mobile Phone</label>
                <div class="col-md-8">
                    <input type="checkbox" name="opt_show_mobilephone" {{ $user->opt_show_mobilephone==true ? ' checked' : ''}} data-toggle="toggle" data-size="mini">
                    @if ($errors->has('opt_show_mobilephone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('opt_show_mobilephone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('opt_show_homephone') ? ' has-error' : '' }}">
                <label class="control-label col-md-4 text-right">Show Home Phone</label>
                <div class="col-md-8">
                    <input type="checkbox" name="opt_show_homephone" {{ $user->opt_show_homephone==true ? ' checked' : ''}} data-toggle="toggle" data-size="mini">
                    @if ($errors->has('opt_show_homephone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('opt_show_homephone') }}</strong>
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
