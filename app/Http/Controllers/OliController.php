<?php

namespace App\Http\Controllers;

use App\Models\Oli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OliController extends Controller
{
   public function listOli()
    {
        try {
            $dataOli = Oli::all();

            return response()->json([
                'id' => '1',
                'data' => $dataOli
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data Oli.'
            ]);
        }
    }

    public function createOli(Request $request)
    {
        try {
            $validateData = $request->validate([
                'merk' => 'required|string',
                'kilometer_mobil' => 'required|string',
                'tanggal_ganti_oli' => 'required|date',
                'harga' => 'required|numeric',
                'nota' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_mobil' => 'required|integer',
                'fk_id_pj' => 'required|integer',
            ]);

            // Simpan nota ke local storage
            $path = $request->file('nota')->store('nota_Oli', 'public');
            $validateData['nota'] = $path;

            Oli::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data Oli berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data Oli.'
            ]);
        }
    }

    public function updateOli(Request $request, $id)
    {
        try {
            $Oli = Oli::findOrFail($id);

            $validateData = $request->validate([
                'merk' => 'required|string',
                'kilometer_mobil' => 'required|string',
                'tanggal_ganti_oli' => 'required|date',
                'harga' => 'required|numeric',
                'nota' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_mobil' => 'required|integer',
                'fk_id_pj' => 'required|integer',
            ]);

            if ($request->hasFile('nota')) {
                if ($Oli->nota && Storage::disk('public')->exists($Oli->nota)) {
                    Storage::disk('public')->delete($Oli->nota);
                }

                $path = $request->file('nota')->store('nota_Oli', 'public');
                $validateData['nota'] = $path;
            }

            $Oli->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data Oli berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data Oli.'
            ]);
        }
    }

    public function deleteOli($id)
    {
        try {
            $Oli = Oli::findOrFail($id);

            if ($Oli->nota && Storage::disk('public')->exists($Oli->nota)) {
                Storage::disk('public')->delete($Oli->nota);
            }

            $Oli->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data Oli berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data Oli.'
            ]);
        }
    }
}
