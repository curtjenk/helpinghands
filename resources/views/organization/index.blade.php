@extends('layouts.app')

@section('content')

<nav-top-2
    title="Organizations"
    :links="[{perm:'Create organization', href:'/organization/create', name:'New', icon:'fa-plus'}]"
></nav-top-2>
<organizationslist
  :is-admin="{{  1 }}"
  :userid="{{ Auth::user()->id }}"
></organizationslist>

<div class="modal fade" id="deleteOrganization" tabindex="-1" user="dialog" aria-labelledby="Confirm delete organization">
  <div class="modal-dialog modal-sm" user="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Organization</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this Organization?
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
