@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header"> Event</div>
            <div class="pull-left">
            @if(isset($event))
                @include('layouts.org_selector', ['specific'=>$event->organization->id])
            @else
                @include('layouts.org_selector')
            @endif
            </div>
            <div class="pull-right">
                <a class="btn btn-default btn-xs"
                href="{{ url('/event') }}">
                <i class="fa fa-list"></i> Events</a>
            @if($event->statusOpen())
                @if(!Auth::user()->signedup($event->id, 'yes'))
                    <a class="btn btn-default btn-xs" style="background-color:#41b5f4"
                    href="{{ url('/event/'.$event->id.'/signup?h=1') }}">
                    <i class="fa fa-thumbs-o-up"></i> Signup</a>
                @endif
                @if(!Auth::user()->signedup($event->id, 'no'))
                    <a class="btn btn-default btn-xs" style="background-color:#f45f42"
                    href="{{ url('/event/'.$event->id.'/signup?h=0') }}">
                    <i class="fa fa-thumbs-o-down"></i> Decline</a>
                @endif
            @endif
            {{--  add vertical bar/line --}}
            <span>&#124;</span>
            @can ('update', $event)
                <a class="btn btn-default btn-xs"
                href="{{ url('/event/'.$event->id.'/edit') }}">
                <i class="fa fa-pencil"></i> Edit</a>
            @endcan
            @can ('create-event')
                <a class="btn btn-default btn-xs"
                href="{{ url('/event/create') }}">
                <i class="fa fa-plus"></i> Create</a>
            @endcan
            @can ('send-evites')
                    @if($event->evite_sent)
                      <a class="btn btn-warning btn-xs"
                      href="{{ url('/evite/'.$event->id) }}">
                      <i class="fa fa-mail-forward"></i> Resend Evite</a>
                    @else
                      <a class="btn btn-default btn-xs"
                      href="{{ url('/evite/'.$event->id) }}">
                      <i class="fa fa-mail-forward"></i> Evite</a>
                    @endif
            @endcan
            </div>

        </div>
    </section>
    <div class="container">
        <div class="row form-horizontal">
            @if(!empty($num_evites))
                <h5 style="color: red">
                    Sent {{ $num_evites }} Evites
                </h5>
            @endif
        </div>
        <div class="row form-horizontal">
            <div class="panel panel-default">
            @if($event->statusOpen())
                @if($errors->any() || isset($msg))
                <?php $message = isset($msg)?$msg : $errors->first(); ?>
                <div class="panel-heading" style="background-color:yellow">
                    <h4 class="text-center"><em>{{$message}}</em></h4>
                </div>
                @elseif(Auth::user()->signedup($event->id, 'yes'))
                <div class="panel-heading" style="background-color:#41b5f4">
                    <h4 class="text-center"><em>You are signed-up!</em></h4>
                </div>
                @elseif (Auth::user()->signedup($event->id,'no'))
                <div class="panel-heading" style="background-color:#f45f42">
                    <h4 class="text-center"><em>You Declined but it's not too late!</em></h4>
                </div>
                @else
                <div class="panel-heading" style="background-color:yellow">
                    <h4 class="text-center"><em>Signup today!</em></h4>
                </div>
                @endif
            @else
                <div class="panel-heading" style="background-color:yellow">
                    <h4 class="text-center"><em>Event is Closed/On-Hold</em></h4>
                </div>
            @endif
                <div class="panel-body">
                    <div class="col-md-5">
                        <label class="col-md-3 control-label">Organization</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{$event->organization->name}}</p>
                        </div>
                        <label class="col-md-3 control-label">Subject</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $event->subject }}</p>
                        </div>
                        <label class="col-md-3 control-label">Start</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $event->date_start }}</p>
                        </div>
                        <label class="col-md-3 control-label">End</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $event->date_end }}</p>
                        </div>
                        <label class="col-md-3 control-label">Cost</label>
                        <div class="col-md-9">
                            <p class="form-control-static">${{ $event->cost }}</p>
                        </div>
                        <label class="col-md-3 control-label">Type</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $event->event_type->name }}</p>
                        </div>
                        <label class="col-md-3 control-label">Status</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $event->status->name }}</p>
                        </div>
                        <label class="col-md-3 control-label">Signup Limit</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $event->signup_limit>0?$event->signup_limit:"None" }}</p>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class='row'>
                            <label class="control-label">Description</label>
                        </div>
                        <div class="row">
                            <textarea class="editTextArea" cols="" rows="10" readonly>{{ $event->description }}
                            </textarea>
                        </div>
                        <div class='row'>
                            <label class="control-label">Attachments</label>
                        </div>
                        <div class="col-md-11 col-md-offset-1">
                        @foreach ($event->files as $file)
                            <div class="col-md-2">
                               <div class="thumbnail">
                                   <a data-toggle="tooltip" title="{{$file->original_filename}}"
                                       href="{{url('/event/'.$event->id.'/download/'.$file->id)}}">
                                      <img src="{{url('/event/'.$event->id.'/download/'.$file->id)}}"
                                          alt="" class="img-responsive" />
                                    </a>
                               </div>
                           </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
