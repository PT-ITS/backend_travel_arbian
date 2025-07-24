<?php

namespace App\Http\Controllers;

use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TujuanController extends Controller
{
        public function listTujuan()
    {
        try {
            $dataTujuan = Tujuan::all();

            return response()->json([
                'id' => '1',
                'data' => $dataTujuan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data tujuan.'
            ]);
        }
    }

    public function createTujuan(Request $request)
    {
        try {
            $validateData = $request->validate([
                'kota' => 'required|string',
                'kecaatan' => 'required|string',
                'tarif' => 'required|integer',
            ]);

            Tujuan::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data tujuan berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data tujuan.'
            ]);
        }
    }

    public function updateTujuan(Request $request, $id)
    {
        try {
            $tujuan = Tujuan::findOrFail($id);

            $validateData = $request->validate([
                'kota' => 'sometimes|required|string',
                'kecaatan' => 'sometimes|required|string',
                'tarif' => 'sometimes|required|integer',
            ]);

            $tujuan->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data tujuan berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data tujuan.'
            ]);
        }
    }

    public function deleteTujuan($id)
    {
        try {
            $tujuan = Tujuan::findOrFail($id);
            $tujuan->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data tujuan berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data tujuan.'
            ]);
        }
    }
}
