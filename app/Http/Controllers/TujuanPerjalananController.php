<?php

namespace App\Http\Controllers;

use App\Models\TujuanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TujuanPerjalananController extends Controller
{
    public function listTujuanPerjalanan()
    {
        try {
            $dataTujuanPerjalanan = TujuanPerjalanan::all();

            return response()->json([
                'id' => '1',
                'data' => $dataTujuanPerjalanan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data TujuanPerjalanan.'
            ]);
        }
    }

    public function createTujuanPerjalanan(Request $request)
    {
        try {
            $validateData = $request->validate([
                'fk_id_perjalanan' => 'required|integer',
                'fk_id_tujuan' => 'required|integer',
            ]);

            TujuanPerjalanan::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data TujuanPerjalanan berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data TujuanPerjalanan.'
            ]);
        }
    }

    public function updateTujuanPerjalanan(Request $request, $id)
    {
        try {
            $TujuanPerjalanan = TujuanPerjalanan::findOrFail($id);

            $validateData = $request->validate([
                'fk_id_perjalanan' => 'sometimes|required|integer',
                'fk_id_tujuan' => 'sometimes|required|integer',
            ]);

            $TujuanPerjalanan->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data TujuanPerjalanan berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data TujuanPerjalanan.'
            ]);
        }
    }

    public function deleteTujuanPerjalanan($id)
    {
        try {
            $TujuanPerjalanan = TujuanPerjalanan::findOrFail($id);
            $TujuanPerjalanan->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data TujuanPerjalanan berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data TujuanPerjalanan.'
            ]);
        }
    }
}
