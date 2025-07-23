<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Mobil;

class MobilController extends Controller
{
    public function listMobile()
    {
        try {
            $dataMobil = Mobil::all();

            return response()->json([
                'id' => '1',
                'data' => $dataMobil
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data mobil.'
            ]);
        }
    }

    public function createMobile(Request $request)
    {
        try {
            $validateData = $request->validate([
                'jenis' => 'required|string',
                'merk' => 'required|string',
                'kapasitas' => 'required|integer',
                'nopol' => 'required|string|unique:mobils,nopol',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_driver' => 'required|integer',
            ]);

            $path = $request->file('foto')->store('foto_mobil', 'public');
            $validateData['foto'] = $path;

            Mobil::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data mobil berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data mobil.'
            ]);
        }
    }

    public function updateMobile(Request $request, $id)
    {
        try {
            $mobil = Mobil::findOrFail($id);

            $validateData = $request->validate([
                'jenis' => 'sometimes|required|string',
                'merk' => 'sometimes|required|string',
                'kapasitas' => 'sometimes|required|integer',
                'nopol' => 'sometimes|required|string|unique:mobils,nopol,' . $id,
                'foto' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_driver' => 'sometimes|required|integer',
            ]);

            if ($request->hasFile('foto')) {
                if ($mobil->foto && Storage::disk('public')->exists($mobil->foto)) {
                    Storage::disk('public')->delete($mobil->foto);
                }

                $path = $request->file('foto')->store('foto_mobil', 'public');
                $validateData['foto'] = $path;
            }

            $mobil->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data mobil berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data mobil.'
            ]);
        }
    }

    public function deleteMobile($id)
    {
        try {
            $mobil = Mobil::findOrFail($id);

            if ($mobil->foto && Storage::disk('public')->exists($mobil->foto)) {
                Storage::disk('public')->delete($mobil->foto);
            }

            $mobil->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data mobil berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data mobil.'
            ]);
        }
    }
}
