@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Service / Fellowship Events</div>
            <div class="pull-right">
                @can ('create-ticket')
                    <a class="btn btn-default" href="{{ url('/ticket/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div>
        </div>
    </section>
    <div class="container">
        <table class="table">
            <thead>
                <tr><td>Subject</td>
                    <td>Description</td>
                    <td class="text-center">Evite?</td>
                    <td>Begin</td>
                    <td>End</td>
                    <td class="text-center">Action</td>
                </tr>
            </thead>
            <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td class="col-md-3">
                      <span data-toggle="tooltip" title="<i>{{ $ticket->subject }}</i>" data-html="true">
                        <a href="{{ url('/ticket/'.$ticket->id) }}">{{ str_limit($ticket->subject, 35) }}</a>
                      </span>
                    </td>
                    <td class="col-md-3">
                      <span data-toggle="tooltip" title="<i>{{ $ticket->description }}</i>" data-html="true">
                        <a href="{{ url('/ticket/'.$ticket->id) }}">{{ str_limit($ticket->description, 35) }}</a>
                      </span>
                    </td>
                    <td class="col-md-1 text-center">
                      @if(empty($ticket->evite_sent))
                         <i class="fa fa-frown-o" style="color: red;"></i>
                      @else
                         <i class="fa fa-check-square" style="color: green;"></i>
                      @endif
                    </td>
                    <td class="col-md-2">
                        {{ $ticket->date_start}}
                    </td>
                    <td class="col-md-2">
                        {{ $ticket->date_end }}
                    </td>
                    <td class="col-md-1 text-center">
                    @can ('update', $ticket)
                        <a href="{{ url('/ticket/'.$ticket->id.'/edit') }}" class="btn btn-xs btn-default" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can ('destroy', $ticket)
                    <span data-toggle="tooltip" title="Delete" data-placement="left" class="">
                      <a href="#" type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#deleteTicket" data-id="{{ $ticket->id }}" data-name="{{ $ticket->subject}}" name="delete_{{ $ticket->id }}">
                          <i class="fa fa-trash"></i>
                      </a>
                    </span>
                    @endcan
                    </td>
                </tr>
            @endforeach
            <tbody>
        </table>
    </div>
</main>

<div class="modal fade" id="deleteTicket" tabindex="-1" user="dialog" aria-labelledby="Confirm delete ticket">
  <div class="modal-dialog modal-sm" user="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Event</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this event?
      </div>
      <div class="modal-footer">
        <form method="POST" action="">
          {{ csrf_field() }}
          <input name="_method" type="hidden" value="DELETE">
          <button type="cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" name="submit">Accept</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
