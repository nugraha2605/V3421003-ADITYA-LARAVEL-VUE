<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    //index
    public function index()
    {
        //get data from table siswas
        $posts = Siswa::orderBy('nama', 'asc')->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Siswa',
            'data'    => $posts
        ], 200);
    }

    //show
    public function show($id)
    {
        //find post by ID
        $post = Siswa::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Siswa',
            'data'    => $post
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'alamat'   => 'required',
            'kota'     => 'required',
            'provinsi' => 'required',
            'email'    => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $post = Siswa::create([
            'nama'      => $request->nama,
            'alamat'    => $request->alamat,
            'kota'      => $request->kota,
            'provinsi'  => $request->provinsi,
            'email'     => $request->email
        ]);

        //success save to database
        if($post) {

            return response()->json([
                'success' => true,
                'message' => 'Input berhasil',
                'data'    => $post
            ], 201);
        }

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Input gagal',
        ], 409);
    }

    //update
    public function update(Request $request, Siswa $siswa)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'alamat'   => 'required',
            'kota'     => 'required',
            'provinsi' => 'required',
            'email'    => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find siswa by ID
        $post = Siswa::findOrFail($post->id);

        if($post) {

            //update siswa
            $post->update([
                'nama'      => $request->nama,
                'alamat'    => $request->alamat,
                'kota'      => $request->kota,
                'provinsi'  => $request->provinsi,
                'email'     => $request->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diupdate',
                'data'    => $post
            ], 200);
        }

        //data siswa not found
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan',
        ], 404);
    }

    //destroy
    public function destroy($id)
    {
        //find siswa by ID
        $post = Siswa::findOrfail($id);

        if($post) {

            //delete siswa
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil dihapus',
            ], 200);
        }

        //data siswa not found
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan',
        ], 404);
    }

}
