@extends('templates.default')

@section('title', 'Manage category')
    
@section('content')
<h2 class="text-center" style="color: white">MANAGE CATEGORY</h2>
<div>
    @include('categories.partials.categoryform')
</div>
    
@endsection