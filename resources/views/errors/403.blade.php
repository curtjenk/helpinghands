@extends('layouts.app')

@section('content')
<main>
    <section class="page-header">
        <div class="container">
            <div class="h1">Error</div>
        </div>
    </section>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            You are not authorized to perform this operation.
        </div>
    </div>
</main>
@endsection
