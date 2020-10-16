@extends('templates.default')

@section('title', 'Album images')

@section('content')
<h1 class="text-center text-bold">ALBUM <a href="{{route('album.edit', $album->id)}}" style='color: red;' title="Modify album">{{$album->album_name}}</a></h1> 
    <div class="alert"></div>
<a href="{{route('albums')}}" class="btn btn-outline-light"><i class="fas fa-arrow-left"></i> Back albums</a>
    @if (session()->has('message'))
        <x-alert-info>
        {{session()->get('message')}}
        </x-alert-info>           
    @endif
<div class="container allcards d-flex flex-row justify-content-around align-items-center flex-wrap my-5">


    @forelse ($images as $image)

    <div class="card my-2" style="width: 18rem; box-shadow: 10px 10px 5px #e1e3e4; min-height: 367.5px">
        <img src="{{asset($image->img_path)}}" class="card-img-top" alt="{{$image->id}}">
        <div class="card-body">
            <h5 class="card-title"><strong>{{$image->name}}</strong></h5>
            <p class="card-text">{{$image->description}}</p>
            <a title="Edit image" class="btn btn-outline-primary" href="{{route('photos.edit', $image->id)}}">
              <span style="color: blue;">
                <i class="fas fa-edit"></i>
              </span>
            </a>
            <a title="Delete image" class="btn btn-outline-danger btndelete" href="{{route('photos.destroy', ['photo' => $image->id])}}">
                <span style="color: red;">
                    <i class="fas fa-trash-alt"></i>
                </span>
            </a>
        </div>
        <p class="ml-3">Created on <span style="color: dodgerblue">{{$image->created_at->diffForHumans()}}</span></p>
    </div>    
    @empty
    <div>
        <h3 class="p-2 text-bold text-center">No images found</h3>
    </div>
        @endforelse

    <div class="my-2 py-1 d-flex justify-content-center">
        {{$images->links()}}
    </div>    

</div>
    
@endsection

@section('footer')
 @parent
    <script>
    $(function () { 
        $('div.alert').fadeOut(5000);

        $('.allcards').on('click', 'a.btndelete', function (el) { 
                el.preventDefault();

                let photoUrl = $(this).attr('href');
                let div = $(this).parent('div');

                $.ajax({
                    url: photoUrl,
                    type: "delete",
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);

                        if(response == 1) {
                            div.parent('div').remove();
                        } else {
                            alert('Problem contacting server');
                        }
                    }
                });

         })
     })


    </script>
@endsection