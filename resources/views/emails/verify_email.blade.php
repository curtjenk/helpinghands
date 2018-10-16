@extends('layouts.email')

@section('content')
<main>
    <div class="page-header mx-auto" style="width:60%;">
        <div class="card">
            <div class="card-header">Verfication</div>
            <div class="card-body">
                <div>
                    One step remaining to "Engage In Ministry"!
                </div>                
                <div>
                    Click the following link to verify your email {{ url('/verifyemail/' . $verify_email_token) }}
                </div>

            </div>
        </div>
    </div>
</main>
@endsection