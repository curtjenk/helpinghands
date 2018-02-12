@extends('layouts.app')

@section('content')

{{--See app\Providers\UserRolesPermissionsProvider.php--}}
{{-- view composer used to shared data across all views --}}
<nav-top-2
    title="Members"
    :user="{{ json_encode($userRolesPermissions['user']) }}"
    :roles="{{ json_encode($userRolesPermissions['roles']) }}"
    :permissions="{{ json_encode($userRolesPermissions['permissions']) }}"
    {{-- :links="[{perm:'Create event', href:'/event/create', name:'Create Event', icon:'fa-plus'}]" --}}
></nav-top-2>
<members-list
 {{-- :is-admin="{{ Auth::user()->is_admin() || Auth::user()->is_orgAdmin() ? 1 : 0 }}"   --}}
 :is-admin="true"
 :userid="{{ Auth::user()->id }}"
></members-list>



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
