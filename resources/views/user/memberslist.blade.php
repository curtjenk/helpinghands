@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Members</div>
        </div>
    </section>
    <div class="container-fluid">
         <memberslist></memberslist>
    </div>
</main>

<div class="modal fade" id="deleteUser" tabindex="-1" user="dialog" aria-labelledby="Confirm delete user">
  <div class="modal-dialog modal-sm" user="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete User</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete user?
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
