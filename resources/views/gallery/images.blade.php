@extends('templates.default')

@section('title', 'Images')
    
@section('content')
<div class="d-flex justify-content-start">
    <div class="p-2">
        <a href="{{route('gallery.albums')}}" class="btn btn-outline-light"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="p-2">
        <h2>Photos - Album(<span style="color: red">{{$album->album_name}}</span>)</h2>
        <small style="color: aliceblue">Click photo to view more big</small>
    </div>
</div>
<div class="row">
    @forelse ($images as $image)
       <div class="col-md-4 col-sm-6 col-lg-2 my-2">
           <a href="{{asset($image->img_path)}}" data-lightbox="{{$album->album_name}}">
            <img data-lightbox="{{$image->id.'-'.$image->name}}" src="{{asset($image->img_path)}}" class="img-fluid img-thumbnail" alt="{{$image->id}}">
           </a>
    </div>    
    @empty
    <div>
        <h3 class="p-2 text-bold text-center">No images found</h3>
    </div>
        @endforelse

 {{--    <div class="my-2 py-1 d-flex justify-content-center">
        {{$images->links()}}
    </div>  --}}   

</div>



    
@endsection

@section('footer')
@parent
    
@endsection