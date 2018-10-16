@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">
                @if(isset($event)) Edit
                @else Create
                @endif
                Event
            </div>
            <div class="pull-left">
            {{-- @if(isset($event))
                @include('layouts.org_selector', ['specific'=>$event->organization->id])
            @else
                @include('layouts.org_selector')
            @endif --}}
            </div>
        </div>
    </section>
    <div class="container">
    @if(isset($event))
        <form class="form-horizontal" method="POST" action="{{ url('/event/'.$event->id) }}" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PUT"/>
    @else
        <form class="form-horizontal" method="POST" action="{{ url('/event') }}" enctype="multipart/form-data">
    @endif
          {{ csrf_field() }}
          @php
              // dump($event);
              // $org = Auth::user()->organization;
              // if (Request::session()->has('orgid')) {
              //    $org = App\Organization::find(Request::session()->get('orgid'));
              // }
          @endphp
          <div class="col-md-5">
            <div class="form-group{{ $errors->has('organization_id') ? ' has-error' : '' }}">
                <label for="organization_id" class="col-md-3 control-label">Organization</label>
                <div class="col-md-9">
                    {{-- <div class="form-control-static">{{$org->name}}</div>
                    <input type="hidden" name="organization_id" value="{{$org->id}}" /> --}}
                </div>
            </div>
            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label for="subject" class="col-md-3 control-label">Subject</label>
                <div class="col-md-9">
                    <input required id="subject" type="text" class="" name="subject" autofocus maxlength="255" value="{{ isset($event) ? $event->subject : old('subject') }}">
                    @if ($errors->has('subject'))
                        <span class="help-block">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('date_start') ? ' has-error' : '' }}">
                <label for="date_start" class="col-md-3 control-label">Start</label>
                <div class="col-md-9">
                    <input required id="dateEventStartPicker" type="text" name="date_start" value="{{ isset($event) ? $event->date_start : old('date_start') }}">
                    @if ($errors->has('date_start'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_start') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('date_end') ? ' has-error' : '' }}">
                <label for="date_end" class="col-md-3 control-label">End</label>
                <div class="col-md-9">
                    <input required id="dateEventEndPicker" type="text" name="date_end" value="{{ isset($event) ? $event->date_end : old('date_end') }}">
                    @if ($errors->has('date_end'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_end') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                <label for="cost" class="col-md-3 control-label">Cost</label>
                <div class="col-md-9">
                    <input required id="cost" type="number" name="cost"  min="0" step="any" value="{{ isset($event) ? $event->cost : (old('cost') ? old('cost') : 0) }}">
                    @if ($errors->has('cost'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cost') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('event_type_id') ? ' has-error' : '' }}">
                <label for="event_type_id" class="col-md-3 control-label">Type</label>
                @if ($errors->has('event_type_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('event_type_id') }}</strong>
                    </span>
                @endif
                <div class="col-md-9">
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
                <label for="signup_limit" class="col-md-3 control-label">Signup Limit</label>
                <div class="col-md-9">
                    <input id="signup_limit" type="number" name="signup_limit"  max="999" value="{{ isset($event) ? $event->signup_limit : (old('signup_limit') ? old('signup_limit') : 0) }}">
                    @if ($errors->has('signup_limit'))
                        <span class="help-block">
                            <strong>{{ $errors->first('signup_limit') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                <label for="status_id" class="col-md-3 control-label">Status</label>
                @if ($errors->has('status_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('status_id') }}</strong>
                    </span>
                @endif
                <div class="col-md-9">
                    <select id="status_id" name="status_id">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{isset($event)&&$event->status_id == $status->id ? 'selected':''}}>
                                {{$status->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <div class="row">
                    <label for="description" class="control-label">Description</label>
                </div>
                <div class="row">
                    <textarea required id="description" cols="" rows="10" class="editTextArea" name="description" >{{ isset($event) ? $event->description : old('description') }}
                    </textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                {{-- <label for="files" class="col-md-2 control-label">Attachment</label> --}}
                <input id="event_file" class="" name="event_file[]" type="file" multiple/>
            </div>
            <div class="form-group">
                <div id="image_preview"></div>
            @if(isset($event))
                <div id="prev_image_preview">
                @foreach ($event->files as $file)
                    <div class="col-md-2">
                        <input id="delete_file" class="red-cb" name="delete_file[]"
                            type="checkbox" value="{{$file->id}}"/>
                        <label for="delete_file"><span><span></span></span></label>
                        <div class="thumbnail" data-toggle="tooltip" title="{{$file->original_filename}}">
                          <img src="{{url('/event/'.$event->id.'/download/'.$file->id)}}"
                              alt="" class="img-responsive" />
                        </div>
                   </div>
                @endforeach
            @endif
            </div>
          </div>

          <div class="col-md-12">
            <div class="block text-center">
                <a class="btn btn-default" href="{{ Request::header('referer') }}">
                    <i class="fa fa-btn fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary" name="submit">
                    <i class="fa fa-btn fa-check"></i> Accept
                </button>
            </div>
          </div>
        </form>
    </div>
</main>

@endsection
