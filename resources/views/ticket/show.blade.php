@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Service / Fellowship Event</div>
            <div class="pull-right">
                <a class="btn btn-default" href="{{ url('/ticket') }}"><i class="fa fa-list"></i> Events</a>
                @can ('update', $ticket)
                <a class="btn btn-default" href="{{ url('/ticket/'.$ticket->id.'/edit') }}"><i class="fa fa-pencil"></i> Edit</a>
                @endcan
                @can ('create-ticket')
                <a class="btn btn-default" href="{{ url('/ticket/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
                @can ('send-evites')
                    @if($ticket->evite_sent)
                      <a class="btn btn-warning" href="{{ url('/evite/'.$ticket->id) }}"><i class="fa fa-mail-forward"></i> Resend Evite</a>
                    @else
                      <a class="btn btn-default" href="{{ url('/evite/'.$ticket->id) }}"><i class="fa fa-mail-forward"></i> Evite</a>
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
        <div class="col-md-8">
            <div class="form-horizontal">
                <div class="panel panel-default">
                    {{-- <div class="panel-heading">
                        <h4>Information</h4>
                    </div> --}}
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="organziation" class="col-md-4 control-label">Organization</label>
                            <div class="col-md-8">
                                <p id="organziation" class="form-control-static">
                                    {{$ticket->organization->name}} {{$ticket->organization->city}} {{$ticket->organization->state}}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-md-4 control-label">Subject</label>
                            <div class="col-md-8">
                                <p id="subject" class="form-control-static">{{ $ticket->subject }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_start" class="col-md-4 control-label">Start</label>
                            <div class="col-md-8">
                                <p id="date_start" class="form-control-static">{{ $ticket->date_start }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_end" class="col-md-4 control-label">End</label>
                            <div class="col-md-8">
                                <p id="date_end" class="form-control-static">{{ $ticket->date_end }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-md-4 control-label">Description</label>
                            <div class="col-md-8">
                                <p id="subject" class="form-control-static">{{ $ticket->description }}</p>
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
