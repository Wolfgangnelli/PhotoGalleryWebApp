<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users');
    }
    /**
     * Create action bottons.
     * 
     */
    private function getUserButtons(User $user)
    {
        $id = $user->id;
        $buttonEdit = '<a href="' . route('users.edit', ['user' => $id]) . '" id="edit-' . $id . '" class="btn btn-sm btn-outline-primary" title="update user"><i class="far fa-edit"></i></a>';

        if ($user->deleted_at) {
            $deleteRoute =  route('users.restore', ['user' => $id]);
            $iconDelete = '<i class="fas fa-trash-restore"></i>';
            $btnId = 'restore-' . $id;
            $classBtn = 'btn-outline-success';
            $title = 'restore user';
        } else {
            $deleteRoute = route('users.destroy', ['user' => $id]);
            $iconDelete = '<i class="fas fa-trash-alt"></i>';
            $btnId = 'delete-' . $id;
            $classBtn = 'btn-outline-danger';
            $title = 'delete user';
        }

        $buttonDelete = '<a href="' . $deleteRoute . '" id="' . $btnId . '" class="btn btn-sm ' . $classBtn . ' mt-1 changeBotton" title="' . $title . '">' . $iconDelete . '</a>';
        $buttonForceDelete = '<a href="' . route('users.destroy', ['user' => $id]) . '?hard=1" id="forceDelete-' . $id . '" class="btn btn-sm btn-outline-danger mt-1 changeBotton" title="force delete user"><i class="fas fa-user-minus"></i></a>';
        return $buttonEdit . $buttonDelete . $buttonForceDelete;
    }

    /**
     * Select the columns from user table model and create table with it.
     */
    public function getUsers()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'deleted_at', 'role'])->orderBy('id')->withTrashed()->get();
        $result = DataTables::of($users)->addColumn('action', function ($user) {
            return $this->getUserButtons($user);
        })->editColumn('created_at', function ($user) {
            return $user->created_at ? $user->created_at->format('d/m/y H:i:s') : '';
        })->editColumn('deleted_at', function ($user) {
            return $user->deleted_at ? $user->deleted_at->format('d/m/y H:i:s') : '';
        })->make(true);
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.edituser')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $user = new User();
        $user->password = bcrypt($request->input('email'));
        $user->fill($request->only(['name', 'email', 'role']));
        $res = $user->save();

        $message = $res ? 'User successfully created' : 'Problem creating user';
        session()->flash('message', $message);
        return redirect()->route('users.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.edituser')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        // Validator::make($request->all(), $this->rules, $this->messages)->validate();

        $user->fill($request->only(['name', 'email', 'role']));
        $res = $user->save();

        $message = $res ? 'User correctly updated' : 'User not updated correctly';
        session()->flash('message', $message);
        return redirect()->route('users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $hard = request('hard', '');
        $res = $hard ? $user->forceDelete() : $user->delete();

        $data = [
            'success' => $res,
            'message' => $res ? 'User deleted correctly' : 'User not deleted correctly'
        ];

        return $data;
    }

    /**
     * Restore the specific user record from a softDelete
     * 
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $res = $user->restore();

        $data = [
            'success' => $res,
            'message' => $res ? 'User restore correctly' : 'User not restore correctly'
        ];

        return $data;
    }
}
