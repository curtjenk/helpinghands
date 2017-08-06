@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header"> Events</div>
            <div class="pull-left" data-list="event">@include('layouts.org_selector')</div>
            <div class="pull-right">
                @can ('create-event')
                    <a class="btn btn-default" href="{{ url('/event/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <eventslist
          :is-admin="{{ Auth::user()->is_admin() || Auth::user()->is_orgAdmin() ? 1 : 0 }}"  >
         </eventslist>
    </div>
</main>
<div class="modal fade" id="eventPay" tabindex="-1" user="dialog" aria-labelledby="Log Event Payment">
  <div class="modal-dialog modal-md" user="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <form method="POST" action="">
          {{ csrf_field() }}
        <div class="modal-body">
            <div id="payups" class="container-fluid">

            </div>
        </div>
        <div class="modal-footer">
          <button type="cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" name="submit">Accept</button>
        </div>
      </form>
    </div>
  </div>
</div>

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
