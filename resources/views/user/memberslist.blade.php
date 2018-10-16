@extends('layouts.app')

@section('content')

    <nav-top-2
        title="Members"
    ></nav-top-2>
    <members-list
     :is-admin="true"
     :userid="{{ Auth::user()->id }}"
    ></members-list>

@endsection
