@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Create an Event</div>
        </div>
    </section>
    <div class="container">

            @if(isset($event))
        <form class="form-horizontal" method="POST" action="{{ url('/event/'.$event->id) }}">
            <input name="_method" type="hidden" value="PUT">
            @else
        <form class="form-horizontal" method="POST" action="{{ url('/event') }}">
            @endif
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
                            <option value="{{ $org->id }}" {{ isset($event)&& $event->organization_id==$org->id?'selected':''}}>
                                {{$org->name}} {{$org->city}} {{$org->state}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label for="subject" class="col-md-4 control-label">Subject</label>
                <div class="col-md-8">
                    <input required id="subject" type="text" class="editInfo" name="subject" autofocus maxlength="255" value="{{ isset($event) ? $event->subject : old('subject') }}">
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
                    <input required id="dateEventStartPicker" type="text" name="date_start" value="{{ isset($event) ? $event->date_start : old('date_start') }}">
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
                    <input required id="dateEventEndPicker" type="text" name="date_end" value="{{ isset($event) ? $event->date_end : old('date_end') }}">
                    @if ($errors->has('date_end'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_end') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                <label for="cost" class="col-md-4 control-label">Cost</label>
                <div class="col-md-5">
                    <input required id="cost" type="number" name="cost"  min="0" step="any" value="{{ isset($event) ? $event->cost : old('cost') }}">
                    @if ($errors->has('cost'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cost') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('event_type_id') ? ' has-error' : '' }}">
                <div class="col-md-4 text-right">
                    <label class="control-label">Type</label>
                    @if ($errors->has('event_type_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('event_type_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-8">
                    <select id="event_type_id" name="event_type_id">
                        @foreach ($event_types as $event_type)
                            <option value="{{ $event_type->id }}" {{isset($event) && $event->event_type_id == $event_type->id ? 'selected':''}}>
                                {{$event_type->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group{{ $errors->has('signup_limit') ? ' has-error' : '' }}">
                <label for="signup_limit" class="col-md-4 control-label">Signup Limit</label>
                <div class="col-md-8">
                    <input id="signup_limit" type="number" name="signup_limit"  max="999" value="{{ isset($event) ? $event->signup_limit : old('signup_limit') }}">
                    @if ($errors->has('signup_limit'))
                        <span class="help-block">
                            <strong>{{ $errors->first('signup_limit') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                <div class="col-md-4 text-right">
                    <label class="control-label">Status</label>
                    @if ($errors->has('status_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-8">
                    <select id="status_id" name="status_id">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{isset($event)&&$event->status_id == $status->id ? 'selected':''}}>
                                {{$status->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description" class="col-md-4 control-label">Description</label>
                <div class="col-md-8">
                    <textarea required id="description" cols="60" rows="5" class="editTextArea" name="description" >{{ isset($event) ? $event->description : old('description') }}
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
