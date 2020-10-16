@extends('templates.default')

@section('title', 'Categories')
    
@section('content')
@include('globalPartials.erroralert')

<div class="my-2">
    <button class="btn btn-outline-success font-weight-bold" id="add-category">ADD CATEGORY</button>
       @include('categories.partials.categoryform')
</div>

    <table class="table table-striped table-dark table-responsive-sm" id="categoryList">
        <caption>List of categories</caption>
        <thead>
            <tr class="text-info">
                <th>ID</th>
                <th class="text-center">Category name</th>
                <th>Created date</th>
                <th>Update date</th>
                <th class="text-center">Number of albums</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
                @forelse ($categories as $categoryI)
        <tr class="text-light" id="tr-{{$categoryI->id}}">
                        <td>{{$categoryI->id}}</td>
                        <td class="text-center" id="catid-{{$categoryI->id}}">{{$categoryI->category_name}}</td>
                        <td>{{$categoryI->created_at}}</td>
                        <td>{{$categoryI->updated_at}}</td>
                        <td class="text-center">{{$categoryI->albums_count}}</td>
                        <td class="d-flex justify-content-center">
                            <a title="Edit category" id="upd-{{$categoryI->id}}" class="btn btn-outline-primary" href="{{route('categories.edit', $categoryI->id)}}">
                                <span style="color: blue;">
                                    <i class="fas fa-edit"></i>
                                </span>
                            </a>
                            <form method="POST" action="{{route('categories.destroy', $categoryI->id)}}">
                                @csrf
                                @method('DELETE')
                                <button id="btnDelete-{{$categoryI->id}}" class="btn btn-outline-danger ml-1" title="Delete category">
                                    <span style="color: red;">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="5">
                        No categories
                    </td>
                </tr>
                @endforelse
        </tbody>
    </table>

    <div class="my-2 py-1 d-flex justify-content-center">
        {{$categories->links()}}
    </div>
@endsection

@section('footer')
@parent
<script>
    $(function () { 
        const form = $('form#new-cat');
        $(form).hide();

            $('div').on('click', 'button#add-category', function (evt) {
                evt.preventDefault();
                let inputCat = $('#category_name');
                inputCat[0].value = '';

                if($(form).hasClass('hid')) {
                    form.delay(500).fadeIn(1000);
                    $(form).removeClass('hid').addClass('show');
                } else if ($(form).hasClass('show')) {
                    form.delay(500).fadeOut(1000);
                    $(form).removeClass('show').addClass('hid');
                }       
            });         
     })
</script>    
<script>
    $(function () {
        const form = $('form#new-cat');
        let inputCat = $('#category_name');
        inputCat[0].value = '';
        function formManageCategory() {
            if($(form).hasClass('hid')) {
                    form.delay(500).fadeIn(1000);
                    $(form).removeClass('hid').addClass('show');
                } else if ($(form).hasClass('show')) {
                    form.delay(500).fadeOut(1000);
                    $(form).removeClass('show').addClass('hid');
                }      
        }

//REMOVE CATEGORY
    $('form .btn-outline-danger').on('click', function (evt) {
        evt.preventDefault();

        let url = $(this).parent('form').attr('action');
        let categoryId = this.id.replace('btnDelete-','')*1;     
        let tr = $('#tr-'+categoryId);
        
        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                console.log(res);
                //let resp = JSON.parse(res);
                $(tr).remove();             
            }
        });    
       // return false;         
    });

//ADD CATEGORY
    $("div button#save").on("click", function (evt) {
        evt.preventDefault();
 /*        console.log(evt.target);
        console.log(this); */
        let inputCat = $('#category_name');
        let url = form.attr('action');
        let data = form.serialize();
        console.log(data);

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function (response) {
                console.log(response);
                alert(response.message);
                 if(response.success) {
                     inputCat[0].value = '';
                    form.delay(500).fadeOut(1000);
                    $(form).removeClass('show').addClass('hid');
                    location.reload();
                } 
            }
        });
    });

//UPDATE CATEGORY
    $('#categoryList').on('click', 'a.btn-outline-primary', function (evt) {
        evt.preventDefault();

        formManageCategory();

        let id = this.id.replace('upd-','');

        let catRow = $('#tr-'+id);
        $('#categoryList').css({
            'border-color': 'transparent'
        });
        catRow.css({
                'border-right': '2px solid green',
                'border-left': '2px solid green'
            });

        let url = this.href.replace('/edit','');
        console.log(url);
        let tdCat = $('#catid-'+id);

        let categoryName = tdCat.text();
        form.attr('action', url);

        form[0].category_name.value = categoryName;
        form[0].category_name.addEventListener('keyup', function () { 
            tdCat.html(form[0].category_name.value);
         });

        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_method';
        input.value = 'PATCH';
        form[0].appendChild(input);
    });
    })
</script>
@endsection