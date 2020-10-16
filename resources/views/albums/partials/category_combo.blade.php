<div class="form-group">
    <label for="categories">Categories: </label>
    <small class="text-white">(for select more categories press <code>ctrl+click</code> on the category)</small>
    <select name="categories[]" id="categories" class="form-control" multiple size="5">
      @foreach ($categories as $cat)
        <option {{ in_array($cat->id, $selectedCategories)? 'selected' : ''}} value="{{$cat->id}}">{{$cat->category_name}}</option>
      @endforeach
    </select>
  </div>