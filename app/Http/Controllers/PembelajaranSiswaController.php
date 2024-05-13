<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembelajaranModel;
use Illuminate\Support\Facades\Validator;

class PembelajaranSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelajaran = PembelajaranModel::get();
        return response()->json([
            'status' => 'success',
            'message' => 'Get All Pembelajaran',
            'data' => $pembelajaran,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'mata_kuliah' => 'required',
            'nilai' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 400);
        }
        $nilai = $request->nilai;
        $index_nilai = $this->konversi_nilai_ke_huruf($nilai);

        $pembelajaran = PembelajaranModel::create([
            'nama' => $request->nama,
            'mata_kuliah' => $request->mata_kuliah,
            'nilai' => $request->nilai,
            'index_nilai' => $index_nilai,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Create Pembelajaran',
            'data' => $pembelajaran,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembelajaran = PembelajaranModel::find($id);
        if (!$pembelajaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembelajaran Not Found',
                'data' => $pembelajaran,
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Get Pembelajaran',
            'data' => $pembelajaran,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pembelajaran = PembelajaranModel::find($id);
        if (!$pembelajaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembelajaran Not Found',
                'data' => $pembelajaran,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'mata_kuliah' => 'required',
            'nilai' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 400);
        }



        $nilai = $request->nilai;
        $index_nilai = $this->konversi_nilai_ke_huruf($nilai);
        $pembelajaran->update([
            'nama' => $request->nama,
            'mata_kuliah' => $request->mata_kuliah,
            'nilai' => $request->nilai,
            'index_nilai' => $index_nilai,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Update Pembelajaran',
            'data' => $pembelajaran,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelajaran = PembelajaranModel::find($id);
        if (!$pembelajaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembelajaran Not Found',
            ], 404);
        }

        $pembelajaran->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete Pembelajaran',
        ], 200);
    }

    private function konversi_nilai_ke_huruf($nilai)
    {
        if ($nilai >= 100) {
            return 'A';
        } elseif ($nilai >= 90) {
            return 'B';
        } elseif ($nilai >= 80) {
            return 'C';
        } elseif ($nilai >= 70) {
            return 'D';
        } else {
            return 'E';
        }
    }
}
