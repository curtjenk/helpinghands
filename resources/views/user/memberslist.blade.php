@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Members</div>
            <div class="pull-left">
            {{-- @if(isset($event))
                @include('layouts.org_selector', ['specific'=>$event->organization->id])
            @else --}}
                @include('layouts.org_selector')
            {{-- @endif --}}
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <memberslist
         :is-admin="{{ Auth::user()->is_admin() || Auth::user()->is_orgAdmin() ? 1 : 0 }}"  >
        </memberslist>
    </div>
</main>

<div class="modal fade" id="proxySignup" tabindex="-1" user="dialog" aria-labelledby="Proxy Signup/Decline">
  <div class="modal-dialog modal-md" user="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <form method="POST" action="">
          {{ csrf_field() }}
        <div class="modal-body">
            <input type="radio" name="action" value="signup" checked> Signup<br>
            <input type="radio" name="action" value="decline"> Decline<br>
            <select id="event_id" name="event_id">
            </select>
        </div>
        <div class="modal-footer">
          <button type="cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" name="submit">Accept</button>
           </div>
      </form>
    </div>
  </div>
</div>
@endsection
