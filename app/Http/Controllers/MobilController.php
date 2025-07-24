<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Mobil;

class MobilController extends Controller
{
    public function detailMobile($id)
    {
        try {
            $dataMobil = Mobil::find($id);

            if ($dataMobil) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataMobil,
                    'message' => 'Data mobil berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data mobil'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => $th->getMessage()
            ]);
        }
    }

    public function listMobile()
    {
        try {
            $dataMobil = Mobil::all();

            if ($dataMobil) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataMobil,
                    'message' => 'Data mobil berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data mobil'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => $th->getMessage()
            ]);
        }
    }

    public function createMobile(Request $request)
    {
        try {
            $validateData = $request->validate([
                'jenis' => 'required|string',
                'merk' => 'required|string',
                'kapasitas' => 'required|numeric',
                'nopol' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                // 'fk_id_driver' => 'required|integer',
            ]);

            $path = $request->file('foto')->store('foto_mobil', 'public');
            $validateData['foto'] = $path;

            Mobil::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data mobil berhasil ditambahkan.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menambahkan data mobil.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }


    public function updateMobile(Request $request, $id)
    {
        try {
            $mobil = Mobil::findOrFail($id);

            $validateData = $request->validate([
                'jenis' => 'required|string',
                'merk' => 'required|string',
                'kapasitas' => 'required|integer',
                'nopol' => 'required|string',
                'foto' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                // 'fk_id_driver' => 'required|integer',
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
                'data' => $validateData,
                'message' => 'Data mobil berhasil diperbarui.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat memperbarui data mobil.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
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
                'data' => [],
                'message' => 'Data mobil berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data mobil.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
