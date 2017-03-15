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
        <table class="table col-md-12">
            <thead>
                <tr><td>Name</td>
                    {{-- <td>Phone</td> --}}
                    <td>Address</td>
                    <td>City</td>
                    <td>State</td>
                    {{-- <td>ZipCode</td> --}}
                    <td class="text-center">Action</td>
                </tr>
            </thead>
            <tbody>
            @foreach ($organizations as $org)
                <tr>
                    <td class="col-md-3">
                        <a href="{{ url('/organization/'.$org->id) }}">{{ $org->name }}</a>
                    </td>
                    {{-- <td class="col-md-1">
                        {{ $org->phone}}
                    </td> --}}
                    <td class="col-md-3">
                        {{ $org->address1 }} {{ $org->address2}}
                    </td>
                    <td class="col-md-2">
                        {{ $org->city}}
                    </td>
                    <td class="col-md-1">
                        {{ $org->state}}
                    </td>
                    {{-- <td class="col-md-1">
                        {{ $org->zipcode}}
                    </td> --}}
                    <td class="col-md-1 text-center">
                    @can ('update', $org)
                        <a href="{{ url('/organization/'.$org->id.'/edit') }}" class="btn btn-xs btn-default" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                    @endcan
                    {{-- @can ('destroy', $org)
                    <span data-toggle="tooltip" title="Delete" data-placement="left" class="">
                      <a href="#" type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#deleteOrganization" data-id="{{ $org->id }}" data-name="{{ $org->name}}" name="delete_{{ $org->id }}">
                          <i class="fa fa-trash"></i>
                      </a>
                    </span>
                    @endcan --}}
                    </td>
                </tr>
            @endforeach
            <tbody>
        </table>
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
