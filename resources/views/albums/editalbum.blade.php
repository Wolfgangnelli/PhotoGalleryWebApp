@extends('templates.default')

@section('title', 'Edit Album')

@section('content')
    <h1 style="color: white; font-weight: bold" class="text-center">Edit Album</h1>

@include('globalPartials.erroralert')

<form action="{{route('album.store',$album->id)}}" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}

  <input type="hidden" name="_method" value="PATCH">

    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" class="form-control" value="{{old('name', $album->album_name)}}" placeholder="Album name" aria-describedby="helpId" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="Album description" aria-describedby="helpId" required>
{{old('description', $album->description)}}
        </textarea>
      </div>
      
@include('albums.partials.category_combo')   
@include('albums.partials.fileupload')
  <div class="d-flex justify-content-center">
    <a title="Back all albums" class="btn btn-light mx-1" href="{{route('albums')}}"><i class="fas fa-arrow-left"></i> Back</a>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-light mx-1" href="{{route('album.getimages', $album->id)}}">Go images <i class="fas fa-arrow-right"></i></a>
  </div>
</form>


@stop