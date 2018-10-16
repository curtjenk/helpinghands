@extends('layouts.app')

@section('content')
    <nav-top-2
        title="Teams"
        :links="[{perm:'List teams', href:'', name:'', icon:''}]"
    ></nav-top-2>
    <teamslist
      :is-admin="{{  1 }}"
      :userid="{{ Auth::user()->id }}"
    ></teamslist>
@endsection
