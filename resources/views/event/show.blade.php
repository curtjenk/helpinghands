@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Service / Fellowship Event</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/event') }}"><i class="fa fa-list"></i> Events</a>
            @if(!Auth::user()->signedup($event->id))
                <a class="btn btn-default" style="background-color:#f45f42" href="{{ url('/event/'.$event->id.'/signup') }}"><i class="fa fa-handshake-o"></i> Signup</a>
            @endif
            @can ('update', $event)
                <a class="btn btn-default" href="{{ url('/event/'.$event->id.'/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
            @endcan
            @can ('create-event')
                <a class="btn btn-default" href="{{ url('/event/create') }}"><i class="fa fa-plus"></i> Create</a>
            @endcan
            @can ('send-evites')
                    @if($event->evite_sent)
                      <a class="btn btn-warning" href="{{ url('/evite/'.$event->id) }}"><i class="fa fa-mail-forward"></i> Resend Evite</a>
                    @else
                      <a class="btn btn-default" href="{{ url('/evite/'.$event->id) }}"><i class="fa fa-mail-forward"></i> Evite</a>
                    @endif
            @endcan
            </div>
        </div>
    </section>
    <div class="container">
        <div class="col-md-2">
            @if(!empty($num_evites))
                <h5 style="color: red">
                    Sent {{ $num_evites }} Evites
                </h5>
            @endif
        </div>
        {{-- {{dump($event)}} --}}
        <div class="col-md-8">
            <div class="form-horizontal">
                <div class="panel panel-default">
                @if(Auth::user()->signedup($event->id))
                    <div class="panel-heading" style="background-color:#41b5f4">
                        <h4 class="text-center"><em>You are signed-up!</em></h4>
                    </div>
                @else
                    <div class="panel-heading" style="background-color:#f45f42">
                        <h4 class="text-center"><em>Signup today!</em></h4>
                    </div>
                @endif
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="organziation" class="col-md-4 control-label">Organization</label>
                            <div class="col-md-8">
                                <p id="organziation" class="form-control-static">
                                    {{$event->organization->name}} {{$event->organization->city}} {{$event->organization->state}}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-md-4 control-label">Subject</label>
                            <div class="col-md-8">
                                <p id="subject" class="form-control-static">{{ $event->subject }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_start" class="col-md-4 control-label">Start</label>
                            <div class="col-md-8">
                                <p id="date_start" class="form-control-static">{{ $event->date_start }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_end" class="col-md-4 control-label">End</label>
                            <div class="col-md-8">
                                <p id="date_end" class="form-control-static">{{ $event->date_end }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-md-8">
                                <p id="status" class="form-control-static">{{ $event->status->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-8">
                                <p id="description" class="form-control-static">{{ $event->description }}</p>
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
