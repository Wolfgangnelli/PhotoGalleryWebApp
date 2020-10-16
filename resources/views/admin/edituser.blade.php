@extends('templates.admin')



@section('content')

@if(session()->has('message'))
<div class="alert alert-info mt-2"><strong>{{session('message')}}</strong></div>
@endif

@if ($user->id)   
<form action="{{route('users.update', $user->id)}}" method="POST">
    @method('PATCH')
    <input type="hidden" name="id" value="{{$user->id}}">
    <h2 class="text-center font-weight-bold ">Edit User</h2>
@else 
<form action="{{route('users.store')}}" method="POST">
    <h2 class="text-center font-weight-bold ">Create User</h2>
@endif
            <div class="form-group">
                <label for="name" style="color: white">User name:</label>
                <input type="text"
                class="form-control" name="name" id="name" value="{{old('name') ? old('name') : $user->name}}" aria-describedby="helpId" placeholder="write new name here" required>
              @error('name')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
                <label for="email" style="color: white">User email:</label>
                <input class="form-control" type="text" name="email" id="email" value="{{old('email') ? old('email') : $user->email}}" aria-describedby="helpId" placeholder="write new email here" required>
              @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
                <label for="role" style="color: white">User role:</label>
                <select class="form-control" name="role" id="role" size="1" required>
                    <option value="">select..</option>
                    <option value="user" {{(old('role') == 'user' || $user->role == 'user') ? 'selected' : ''}}>user</option>
                    <option value="admin" {{(old('role') == 'admin' || $user->role == 'admin') ? 'selected' : ''}}>admin</option>
                </select>
               @error('role')
                  <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>
            <div class="form-group d-flex justify-content-between">
                <div>
                    <a title="Back all users" class="btn btn-light mx-1" href="{{route('user-list')}}"><i class="fas fa-arrow-left"></i> Back</a>
                </div>
                <div>
                    <button id="save" class="btn btn-outline-success" type="submit">SAVE</button>
                    <button id="reset" type="reset" class="btn btn-outline-warning ml-2" value="reset">RESET</button>
                </div>
            </div>
        @csrf
    </form>
@endsection


