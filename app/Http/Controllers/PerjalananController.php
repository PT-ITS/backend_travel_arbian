<?php

namespace App\Http\Controllers;

use App\Models\Perjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerjalananController extends Controller
{
        public function listPerjalanan()
    {
        try {
            $dataPerjalanan = Perjalanan::all();

            return response()->json([
                'id' => '1',
                'data' => $dataPerjalanan
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data Perjalanan.'
            ]);
        }
    }

    public function createPerjalanan(Request $request)
    {
        try {
            $validateData = $request->validate([
                'waktu_berangkat' => 'required',
                'waktu_kembali' => 'required',
                'fk_id_mobil' => 'required|integer',
                'fk_id_pj' => 'required|integer',
            ]);

            Perjalanan::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data Perjalanan berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data Perjalanan.'
            ]);
        }
    }

    public function updatePerjalanan(Request $request, $id)
    {
        try {
            $Perjalanan = Perjalanan::findOrFail($id);

            $validateData = $request->validate([
                'waktu_berangkat' => 'sometimes|required',
                'waktu_kembali' => 'sometimes|required',
                'fk_id_mobil' => 'sometimes|required|integer',
                'fk_id_pj' => 'sometimes|required|integer',
            ]);

            $Perjalanan->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data Perjalanan berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data Perjalanan.'
            ]);
        }
    }

    public function deletePerjalanan($id)
    {
        try {
            $Perjalanan = Perjalanan::findOrFail($id);
            $Perjalanan->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data Perjalanan berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data Perjalanan.'
            ]);
        }
    }
}
