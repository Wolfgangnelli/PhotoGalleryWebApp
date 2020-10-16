@extends('templates.default')

@section('title', 'Create new album')
    
@section('content')
    
<h1>Create new album</h1>

@include('globalPartials.erroralert')

<form action="{{route('album.save')}}" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}

    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" placeholder="Album name" aria-describedby="helpId" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="Album description" aria-describedby="helpId">{{old('description')}}</textarea>
    </div>
   
      @include('albums.partials.category_combo')   
      @include('albums.partials.fileupload')

    <div class="d-flex justify-content-center mt-5">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>



@stop