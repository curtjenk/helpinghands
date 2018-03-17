@extends('layouts.app')

@section('content')



        <organization-manager
            mode0="{{ $mode }}"
            :user0="{{ Auth::user() }}"
            :orgteams0="{{ $organization }}"
            :members0="{{ $members }}"

        ></organization-manager>


@endsection
