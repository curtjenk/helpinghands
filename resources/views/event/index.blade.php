@extends('layouts.app')

@section('content')
{{--See app\Providers\UserRolesPermissionsProvider.php--}}
{{-- view composer used to shared data across all views --}}
<nav-top-2
    title="Events"
    :links="[{perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]"
></nav-top-2>

<events-list></events-list>

<div class="modal fade" id="eventPay" tabindex="-1" role="dialog" aria-labelledby="Log Event Payment">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <div class="container-fluid">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">placeholder</h4>
           </div>
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

<div class="modal fade" id="eventnotify" tabindex="-1" role="dialog" aria-labelledby="Send Notification event">
  <div class="modal-dialog" role="document" style="width: 41%;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="container-fluid">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">placeholder</h4>
            <div class="">Enter brief message below</div>
         </div>
      </div>
      <form method="POST" action="">
        <div class="modal-body">
            <textarea required cols="35" rows="7" class="form-control" name="message" >
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
