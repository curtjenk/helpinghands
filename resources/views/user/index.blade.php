@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="pull-left header">Users</div>
            {{-- <div class="pull-right printHide">
                @can ('create-user')
                    <a class="btn btn-default" href="{{ url('/user/create') }}"><i class="fa fa-plus"></i> Create</a>
                @endcan
            </div> --}}
        </div>
    </section>
    <div class="container">
        <table class="table">
            <thead>
                <tr><td>Name</td><td>Organization</td><td class="printHide">Action</td></tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ url('/user/'.$user->id) }}">{{ $user->name }}</a>
                    </td>
                    <td>
                        {{ $user->organization->name}}
                    </td>
                    <td class="printHide">
                    @can ('update', $user)
                        <a href="{{ url('/user/'.$user->id.'/edit') }}" class="btn btn-xs btn-default" data-toggle="tooltip" title="Edit User" data-placement="left">
                            <i class="fa fa-pencil"></i>
                        </a>
                    @endcan
                    @can ('destroy', $user)
                    <span data-toggle="tooltip" title="Delete User" data-placement="left" class="printHide">
                      <a href="#" type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#deleteUser" data-id="{{ $user->id }}" data-name="{{ $user->name}}" name="delete_{{ $user->id }}">
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
