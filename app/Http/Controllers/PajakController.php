<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PajakController extends Controller
{
    public function listPajak()
    {
        try {
            $dataPajak = Pajak::all();

            return response()->json([
                'id' => '1',
                'data' => $dataPajak
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data pajak.'
            ]);
        }
    }

    public function createPajak(Request $request)
    {
        try {
            $validateData = $request->validate([
                'tanggal_pajak' => 'required|date',
                'jenis_pajak' => 'required|string',
                'lokasi_samsat' => 'required|string',
                'biaya' => 'required|numeric',
                'nota' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_mobil' => 'required|integer',
                'fk_id_pj' => 'required|integer',
            ]);

            $path = $request->file('nota')->store('nota_pajak', 'public');
            $validateData['nota'] = $path;

            Pajak::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data pajak berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data pajak.'
            ]);
        }
    }

    public function updatePajak(Request $request, $id)
    {
        try {
            $pajak = Pajak::findOrFail($id);

            $validateData = $request->validate([
                'tanggal_pajak' => 'sometimes|required|date',
                'jenis_pajak' => 'sometimes|required|string',
                'lokasi_samsat' => 'sometimes|required|string',
                'biaya' => 'sometimes|required|numeric',
                'nota' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_mobil' => 'sometimes|required|integer',
                'fk_id_pj' => 'sometimes|required|integer',
            ]);

            if ($request->hasFile('nota')) {
                if ($pajak->nota && Storage::disk('public')->exists($pajak->nota)) {
                    Storage::disk('public')->delete($pajak->nota);
                }

                $path = $request->file('nota')->store('nota_pajak', 'public');
                $validateData['nota'] = $path;
            }

            $pajak->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data pajak berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data pajak.'
            ]);
        }
    }

    public function deletePajak($id)
    {
        try {
            $pajak = Pajak::findOrFail($id);

            if ($pajak->nota && Storage::disk('public')->exists($pajak->nota)) {
                Storage::disk('public')->delete($pajak->nota);
            }

            $pajak->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data pajak berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data pajak.'
            ]);
        }
    }
}
