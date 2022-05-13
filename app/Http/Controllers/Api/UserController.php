<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->route = 'user';
        $this->middleware('permission:view-' . $this->route, ['only' => ['index', 'show']]);
        $this->middleware('permission:create-' . $this->route, ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-' . $this->route, ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-' . $this->route, ['only' => ['delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $name = request()->name;
            $username = request()->username;
            $email = request()->email;

            $message = 'Daftar User';

            $query = $this->model()->with('role');
            $query = $query->where('name', 'like', '%' . $name . '%');
            $query = $query->where('username', 'like', '%' . $username . '%');
            $query = $query->where('email', 'like', '%' . $email . '%');

            $data = $query->get();

            $result =  UserResource::collection($data);

            return $this->sendResponse($result, $message, 200);
        } catch (\Throwable $th) {
            $message = 'User not found';
            $response = [
                'success' => false,
                'message' => $message,
                'code' => '404'
            ];
            return $this->sendError($response, $th, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute tidak boleh sama',
            'same' => 'Password dan konfirmasi password harus sama',
        ];

        $this->validate(request(), [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'password_confrim' => 'required|same:password|min:6',
        ], $messages);

        DB::beginTransaction();
        try {
            DB::commit();
            $roles = $request->role;

            $pass = bcrypt(request()->input('password'));
            $name = request()->input('name');

            $user = $this->model();
            $user->name = $name;
            $user->username = $request->username;
            $user->email = request()->input('email');
            $user->password = $pass;
            $user->save();

            $user->role()->attach($roles);

            $result = [];
            $message = 'Berhasil Menyimpan User';
            return $this->sendResponse($result, $message, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = 'Gagal Menyimpan User';
            $response = [
                'success' => false,
                'message' => $message,
                'code' => '401'
            ];
            return $this->sendError($response, $th, 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->model()->find($id);
            $message = 'Detail User ' . $data->name;
            $result =  UserResource::collection($data);
            return $this->sendResponse($result, $message, 200);
        } catch (\Throwable $th) {
            $message = 'User not found';
            $response = [
                'success' => false,
                'message' => $message,
                'code' => '404'
            ];
            return $this->sendError($response, $th, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute tidak boleh sama',
            'same' => ':attribute password dan confrim password harus sama',
        ];

        $this->validate(request(), [
            'name' => 'required|unique:users,name,' . $id,
            'email' => 'required|unique:users,email,' . $id
        ], $messages);

        $user = User::find($id);
        $name = request()->input('name');
        if (request()->input('password')) {
            # code...
            $pass = bcrypt(request()->input('password'));
            $user->password = $pass;
            $this->validate(request(), [
                'name' => 'required|unique:users,name,' . $id,
                'email' => 'required|unique:users,email,' . $id,
                'password' => 'required|min:6',
                'password_confrim' => 'required|same:password|min:6',
            ], $messages);
        }

        DB::beginTransaction();
        $roles = $request->rule;

        $pass = bcrypt(request()->input('password'));
        $name = request()->input('name');

        $user = $this->model()->find($id);
        $user->name = $name;
        $user->username = $request->username;
        $user->email = request()->input('email');
        $user->password = $pass;
        $user->save();

        // update Role
        $roles = $request->role;
        if ($roles) {
            Role::find($roles)->permissions()->pluck('id');
            $user->role()->sync($roles);
        }

        $result = [];
        $message = 'Berhasil Menyimpan User';
        return $this->sendResponse($result, $message, 200);
        try {
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $message = 'User not found';
            $response = [
                'success' => false,
                'message' => $message,
                'code' => '404'
            ];
            return $this->sendError($response, $th, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $message = 'User Berhasil dihapus';
            $this->model()->find($id)->delete();
            return $this->sendResponse([], $message, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = 'User not found';
            $response = [
                'success' => false,
                'message' => $message,
                'code' => '404'
            ];
            return $this->sendError($response, $th, 404);
        }
    }

    private function model()
    {
        return new User();
    }
}
