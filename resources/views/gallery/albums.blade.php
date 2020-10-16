@extends('templates.default')

@section('title', 'Albums gallery')

@section('content')


<div>
  <h1 class="text-center" style="color: chartreuse"><strong>ALL ALBUMS</strong></h1>
    <ul class="list-group mx-auto">

@foreach ($albums as $album)
     
             <li id="li{{$album->id}}" class="list-group-item d-flex align-items-center justify-content-between flex-wrap m-2" style="box-shadow: 10px 10px 5px #e1e3e4;">
               <div class="d-flex justify-content-center flex-column mx-auto">
                 <p class="text-center"><strong>{{$album->id}} - {{$album->album_name}}</strong></p>
                   @if ($album->album_thumb)
                   <figure class="d-flex justify-content-center">
                     <img class="rounded" width="220" height="180" src="{{asset($album->path)}}" alt="{{$album->album_name}}" title="{{$album->album_name}}">
                   </figure>
                   @endif
                   <p class="text-center mx-auto" style="max-width: 50%">{{$album->description}}</p>
                   <div class="d-flex justify-content-center">
                     <h6 class="p-1">Tags: </h6>
                     @if (count($album->categories))
                      @foreach ($album->categories as $cat)
                          <a href="{{route('gallery.album.category', $cat->id)}}" class="p-1">{{$cat->category_name}}</a>
                      @endforeach  
                     @else
                  <p class="p-1">No categories bound</p>
                     @endif
                   </div>
                   <a class="btn btn-primary mx-auto mt-4 mb-2 p-1" style="width: 40%" href="{{route('gallery.album.images', $album->id)}}">View photos</a>
                   <p class="mx-auto text-info">Creator <span style="color: dodgerblue">{{$album->user->fullname}}</span> on <span style="color: dodgerblue">{{$album->created_at->diffForHumans()}}</span></p>
               </div>
              
             </li>
@endforeach
         </ul>
         <div class="my-2 py-1 d-flex justify-content-center flex-wrap">
             {{$albums->links()}}
         </div> 
       </div>


@endsection

@section('footer')
@parent
    
@endsection