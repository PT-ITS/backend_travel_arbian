<?php

namespace App\Http\Controllers;

use App\Models\Tilang;
use Illuminate\Http\Request;

class TilangController extends Controller
{
    public function listTilang()
    {
        try {
            $dataTilang = Tilang::all();

            return response()->json([
                'id' => '1',
                'data' => $dataTilang
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data tilang.'
            ]);
        }
    }

    public function createTilang(Request $request)
    {
        try {
            $validateData = $request->validate([
                'tanggal_tilang' => 'required|date',
                'jenis_pelanggaran' => 'required|string',
                'keterangan' => 'required|string',
                'lokasi' => 'required|string',
                'fk_id_mobil' => 'required|integer',
                'fk_id_pj' => 'required|integer',
            ]);

            Tilang::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data tilang berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data tilang.'
            ]);
        }
    }

    public function updateTilang(Request $request, $id)
    {
        try {
            $tilang = Tilang::findOrFail($id);

            $validateData = $request->validate([
                'tanggal_tilang' => 'sometimes|required|date',
                'jenis_pelanggaran' => 'sometimes|required|string',
                'keterangan' => 'sometimes|required|string',
                'lokasi' => 'sometimes|required|string',
                'fk_id_mobil' => 'sometimes|required|integer',
                'fk_id_pj' => 'sometimes|required|integer',
            ]);

            $tilang->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data tilang berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data tilang.'
            ]);
        }
    }

    public function deleteTilang($id)
    {
        try {
            $tilang = Tilang::findOrFail($id);
            $tilang->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data tilang berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data tilang.'
            ]);
        }
    }
}
