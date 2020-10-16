@extends('templates.admin')

@section('content')
<h1 class="text-center font-weight-bold">Users List</h1>

<div class="table-responsive">
    <table class="table table-striped table-dark table-bordered tableUsers" id="users-table">
        <thead class="thead-inverse">
            <tr style="color: rgb(0, 110, 255);" >
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>CREATED_AT</th>
                <th>DELETED_AT</th>
                <th>ROLE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>

    </table>
</div>
@endsection

@section('footer')
@parent
    <script>
      

     var table =  $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{route('admin.getUsers')}}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created'},
            {data: 'deleted_at', name: 'deleted'},
            {data: 'role', name: 'role'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
           ]
         }); 

    $(function () {
    
         $('#users-table').on('click', '.changeBotton', function (evt) { 
        evt.preventDefault();

        let id = this.id;
        let actionConfirm = (id.startsWith('delete') || id.startsWith('forceDelete')) ? "delete" : "restore";

        if(!confirm('Do you really want really '+ actionConfirm +' this record? ')) {
            return false;
        }
        
        //alert(evt.target.href);
        let urlUsers = this.href;
        let tr = this.parentNode.parentNode;

      $.ajax({
       url: urlUsers,   
       type: (id.startsWith('delete') || id.startsWith('forceDelete')) ? "DELETE" : "PATCH", 
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
          if(response.success == 1) {
                if(urlUsers.endsWith('hard=1')) {
                tr.remove();
                }
                table.ajax.reload();
                alert(response.message);
            }
          alert(response.message);

        }
        }); 

      })
        })

    </script>
@endsection