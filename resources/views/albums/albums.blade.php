@extends('templates.default')

@section('title', 'Albums')

@section('content')
<div class="d-flex justify-content-center">
  <h1>ALBUMS</h1>
</div>

@if (session()->has('message'))

<x-alert-info>
  {{session()->get('message')}}
</x-alert-info>
    
@endif

  <div>
   <ul class="list-group">
        @foreach ($albums as $album)

        <li id="li{{$album->id}}" class="list-group-item d-flex align-items-center justify-content-between flex-wrap m-2" style="box-shadow: 10px 10px 5px #e1e3e4;">
          <div class="d-flex justify-content-center flex-column mx-auto">
            <p><strong>{{$album->id}} - {{$album->album_name}}</strong></p>
              @if ($album->album_thumb)
              <figure>
                <img width="120" height="120" src="{{asset($album->path)}}" alt="{{$album->album_name}}" title="{{$album->album_name}}">
              </figure>
              @endif

              <div class="d-flex">
                <h6 class="p-1">Tags: </h6>
                @if (count($album->categories))
                  <div class="ml-2 d-flex justify-content-center">
                    @foreach ($album->categories as $cat)
                    <a href="#" class="p-1">{{$cat->category_name}}</a>
                    @endforeach
                  </div>
                @else
                  <p class="p-1">No categories bound</p>
                @endif
              </div>

              <p>Creator <span style="color: dodgerblue">{{$album->user->fullname}}</span> on <span style="color: dodgerblue">{{$album->created_at->diffForHumans()}}</span></p>
          </div>
          <div class="d-flex flex-wrap justify-content-center">
            <a title="Add image" class="btn btn-outline-secondary m-2" href="{{route('photos.create')}}?album_id={{$album->id}}">
              <span style="color: goldenrod;">
                <i class="far fa-plus-square"></i>
              </span>
            </a>
            @if ($album->photos_count)
            <a title="View images" class="btn btn-outline-success m-2" href="{{route('album.getimages', $album->id)}}">
              <span style="color: green;">
                <i class="fas fa-eye"></i> ({{$album->photos_count}})
              </span>
            </a>                
            @endif
                <a title="UpDate album" class="btn btn-outline-primary m-2" href="{{route('album.edit', $album->id)}}">
                  <span style="color: blue;">
                    <i class="fas fa-edit"></i>
                  </span>
                </a> 
                <form id="form{{$album->id}}" action="{{route('album.delete', $album->id)}}" method="POST">
                  @csrf
                  @method('DELETE')

                    <button id="{{$album->id}}" title="Delete album" class="btn btn-outline-danger m-2">
                      <span style="color: red;">
                        <i class="fas fa-trash-alt"></i>
                      </span>
                    </button>
                </form>
          </div>
        </li>
        @endforeach
    </ul>
    <div class="my-2 py-1 d-flex justify-content-center">
        {{$albums->links()}}
    </div>
  </div>

@endsection  

@section('footer')
@parent
    <script>
      //alert('test')
      $(function() {
      $('div.alert').fadeOut(5000);

      $('form').on('click', 'button.btn-outline-danger', function (evt) { 
        evt.preventDefault();

        //alert(el.target.href);
        let id = evt.target.id;
        let form = $('#form'+id);

        let urlAlbum = form.attr('action');
        let li = $('#li'+id);  

      // el.target.parentNode; 

      $.ajax({
       url: urlAlbum,   
       type: "delete", 
       data: {
             '_token': '{{csrf_token()}}' //$('#_token').val()
       },
        success: function (response) {
            console.log(response);
          if(response == 1) {
            //alert(response);
            //li.parentNode.removeChild(li);
            li.remove();
          } else {
          alert('Problem contacting server');

          }
        }
        });

      })
      });
    </script>
@endsection
