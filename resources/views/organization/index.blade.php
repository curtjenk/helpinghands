@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Organizations</div>
            <div class="pull-right">
                @can ('create-organization')
                    <a class="btn btn-default" href="{{ url('/organization/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div>
        </div>
    </section>
    <div class="container">
        <organizationslist
          :is-admin="{{  1 }}"
          :userid="{{ Auth::user()->id }}"
        ></organizationslist>
    </div>
</main>

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
