
<form id="new-cat" action="{{$category->category_name ? route('categories.update', $category->id) : route('categories.store')}}" method="POST" class="py-3 hid">
    @csrf
    @if ($category->category_name)
        @method('PATCH')
    @endif
    <div class="form-group">
        <label for="category_name">Category name:</label>
        <input type="text" name="category_name" id="category_name" class="form-control" value="{{$category->category_name ? $category->category_name : ''}}" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" id="save">SAVE</button>
    </div>
</form>