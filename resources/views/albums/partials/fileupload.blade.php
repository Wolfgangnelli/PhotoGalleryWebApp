<div class="form-group">
    <label for="album_thumb">Thumbnail</label>
    <input type="file" name="album_thumb" id="album_thumb" class="form-control" value="{{$album->album_thumb}}">
  </div>
  @if ($album->album_thumb)
    <figure >
      <img class="img-thumbnail" src="{{asset($album->path)}}" title="{{$album->album_name}}" alt="{{$album->album_name}}">
      <figcaption>Fig.1 - Thumbnail</figcaption>
    </figure>
  @endif