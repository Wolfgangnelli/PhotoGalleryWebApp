<div class="form-group">
    <label for="img_path" style="color: greenyellow">Image</label>
    <input type="file" class="form-control" name="img_path" id="img_path" placeholder="The image" value="{{asset($photo->img_path)}}">
  </div>

  @if ($photo->img_path)    
      <figure class="figure">
          <img src="{{asset($photo->img_path)}}" class="figure-img img-fluid rounded" alt="{{$photo->name}}">
          <figcaption class="figure-caption text-xs-right">Fig. {{$photo->name}}</figcaption>
      </figure>
  @endif