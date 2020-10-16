@extends('templates.default')

@section('title','Edit image')

@section('content')

@include('globalPartials.erroralert')

@if ($photo->id)
  <form action="{{route('photos.update', $photo->id)}}" method="POST" enctype="multipart/form-data">
   @method('PATCH')
  
@else
  <form action="{{route('photos.store')}}" method="POST" enctype="multipart/form-data">
  
@endif
  
  
  {{-- <input type="hidden" name="album_id" value="{{$photo->album_id?$photo->album_id : $album->id}}"> --}}
  @csrf



    <h2 class="text-center my-2" style="color: red;">{{$photo->id ? 'Edit image '.$photo->id : '' }} {{$photo->name ? $photo->name : 'New Image'}}</h2>

    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" class="form-control" placeholder="Photo name" value="{{$photo->name}}" aria-describedby="helpId" required>
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea name="description" id="description" class="form-control" placeholder="Photo description" aria-describedby="helpId" required>{{$photo->description}}</textarea>
    </div>

    <div class="form-group">
      <label for="album_id">Albums</label>
      <select class="form-control" name="album_id" id="album_id">
        <option value="">Select album if you want changed..</option>
        @foreach ($albums as $item)

          <option {{$item->id == $album->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->album_name}}</option>
            
        @endforeach
      </select>
    </div>

    <div class="form-group">
@include('images_views.partials.fileupload')
    </div>

    <div class="mt-2 mb-4 d-flex justify-content-center">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</form>
    
@endsection