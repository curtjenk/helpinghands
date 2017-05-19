@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Service / Fellowship Events</div>
            <div class="pull-right">
                @can ('create-event')
                    <a class="btn btn-default" href="{{ url('/event/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <eventslist
          isAdmin="{{ Auth::user()->is_admin() || Auth::user()->is_orgAdmin()
              ? 'true':'false'}}"
        >

         </eventslist>
    </div>
    {{-- <div class="container">
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
            @foreach ($events as $event)
                <tr>
                    <td class="col-md-3">
                      <span data-toggle="tooltip" title="<i>{{ $event->subject }}</i>" data-html="true">
                        <a href="{{ url('/event/'.$event->id) }}">{{ str_limit($event->subject, 35) }}</a>
                      </span>
                    </td>
                    <td class="col-md-3">
                      <span data-toggle="tooltip" title="<i>{{ $event->description }}</i>" data-html="true">
                        <a href="{{ url('/event/'.$event->id) }}">{{ str_limit($event->description, 35) }}</a>
                      </span>
                    </td>
                    <td class="col-md-1 text-center">
                      @if(empty($event->evite_sent))
                         <i class="fa fa-frown-o" style="color: red;"></i>
                      @else
                         <i class="fa fa-check-square" style="color: green;"></i>
                      @endif
                    </td>
                    <td class="col-md-2">
                        {{ $event->date_start}}
                    </td>
                    <td class="col-md-2">
                        {{ $event->date_end }}
                    </td>
                    <td class="col-md-1 text-center">
                    @can ('update', $event)
                        <a href="{{ url('/event/'.$event->id.'/edit') }}" class="btn btn-xs btn-default" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                    @endcan
                    @can ('destroy', $event)
                    <span data-toggle="tooltip" title="Delete" data-placement="right" class="">
                      <a href="#" type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#deleteevent" data-id="{{ $event->id }}" data-name="{{ $event->subject}}" name="delete_{{ $event->id }}">
                          <i class="fa fa-trash"></i>
                      </a>
                    </span>
                    @endcan
                    </td>
                </tr>
            @endforeach
            <tbody>
        </table>
    </div> --}}
</main>

<div class="modal fade" id="deleteevent" tabindex="-1" user="dialog" aria-labelledby="Confirm delete event">
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

<div class="modal fade" id="eventnotify" tabindex="-1" user="dialog" aria-labelledby="Send Notification event">
  <div class="modal-dialog modal-sm" user="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">placeholder</h4>
        <div class="text-center">Enter brief message below</div>
      </div>
      <form method="POST" action="">
        <div class="modal-body">
            <textarea required cols="35" rows="7" class="" name="message" >
            </textarea>
        </div>
        <div class="modal-footer">
          {{ csrf_field() }}
          <button type="cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" name="submit">Accept</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
