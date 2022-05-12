<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Traits\ConstructPermissionsTrait;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    use ConstructPermissionsTrait;

    public function routeName()
    {
        return 'satuan';
    }

    public function modelName()
    {
        return new Satuan();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->get('search') ?: '';
        $limit = request()->get('limit') ?: 50;
        $query = $this->modelName()::query();
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }
        $tasks = $query->orderBy('nama', 'ASC')
            ->paginate($limit);

        return $this->sendResponse($tasks, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'unique' => ':attribute tidak boleh sama dengan data yang terdahulu',
            'same' => 'Password dan konfirmasi password harus sama',
        ];

        $this->validate(request(), [
            'nama' => 'required|unique:satuans|max:10',
        ], $messages);


        $nama = $request->nama;

        $data = $this->modelName();
        $data->nama =  $nama;
        $data->save();

        $message = "Sukses menyimpan " . ucfirst($this->routeName());

        return $this->sendResponse($data, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = $this->modelName()->whereSlug($slug)->first();
        $message = "Detail " . ucfirst($this->routeName());

        return $this->sendResponse($data, $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->modelName()->whereslug($id);
        $message = "Sukses menyimpan " . ucfirst($this->routeName());

        return $this->sendResponse($data, $message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute tidak boleh sama dengan data yang terdahulu',
            'same' => 'Password dan konfirmasi password harus sama',
        ];

        $nama = $request->nama;
        $data = $this->modelName()->whereslug($slug)->first();

        $this->validate(request(), [
            'nama' => 'required|unique:satuans,nama,' . $data->id,
        ], $messages);


        $data->nama =  $nama;
        $data->save();

        $message = "Sukses mengubah " . ucfirst($this->routeName());

        return $this->sendResponse($data, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Satuan $satuan)
    {
        //
    }
}
