@extends('layouts.app')

@section('content')

    <nav-top-2
        title="Members"
        :links="[{perm:'Create user', href:'/member/create', name:'Add Member', icon:'fa-plus'}]"
    ></nav-top-2>
    <members-list
     :is-admin="true"
     :userid="{{ Auth::user()->id }}"
    ></members-list>

@endsection
