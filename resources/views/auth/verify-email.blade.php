@extends('templates.default')
@section('content')
    
<div class="alert alert-info mt-5 mx-2" role="alert">
    <h4 class="alert-heading">Access denied!</h4>
    <p>Please, you must verifying your email address first. <i class="far fa-smile-beam"></i></p>
    <p class="mb-0">You must to click on the email verification link that was emailed to you by Albums Laravel App.</p>
    <hr>
    <p>If you don't have receved the email click here: <form action="{{route('verification.send')}}" method="post"><button class="btn btn-info" type="submit">RESENDING VERIFICATION EMAIL</button></form></p>
</div>
@endsection