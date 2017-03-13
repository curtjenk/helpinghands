@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Create Service or Fellowship Event</div>
        </div>
    </section>
    <div class="container">
        <form class="form-horizontal" method="POST" action="{{ url('/ticket') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('organization_id') ? ' has-error' : '' }}">
                <div class="col-md-4 text-right">
                    <label class="control-label">Organization</label>
                    @if ($errors->has('organization_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('organization_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-8">
                    <select id="organization_id" name="organization_id">
                        @foreach ($orgs as $org)
                            <option value="{{ $org->id }}"> {{$org->name}} {{$org->city}} {{$org->state}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label for="subject" class="col-md-4 control-label">Subject</label>
                <div class="col-md-8">
                    <input required id="subject" type="text" class="editInfo" name="subject" autofocus maxlength="255" value="{{ old('subject') }}">
                    @if ($errors->has('subject'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                <label for="date_start" class="col-md-4 control-label">Start</label>
                <div class="col-md-5">
                    <input required id="dateTicketStartPicker" type="text" name="date_start" autofocus value="{{ old('date_start') }}">
                    @if ($errors->has('date_start'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_start') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                <label for="date_end" class="col-md-4 control-label">End</label>
                <div class="col-md-5">
                    <input required id="dateTicketEndPicker" type="text" name="date_end" autofocus value="{{ old('date_end') }}">
                    @if ($errors->has('date_end'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_end') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description" class="col-md-4 control-label">Description</label>
                <div class="col-md-8">
                    <textarea required id="description" cols="60" rows="10" class="editTextArea" name="description" value="{{ old('description') }}" >
                    </textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
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
