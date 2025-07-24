<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PajakController extends Controller
{
    public function detailPajak($id)
    {
        try {
            $dataPajak = Pajak::find($id);

            if ($dataPajak) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataPajak,
                    'message' => 'Data pajak berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data pajak'
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

    public function listPajak()
    {
        try {
            $dataPajak = Pajak::all();

            if ($dataPajak) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataPajak,
                    'message' => 'Data pajak berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data pajak'
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
                'data' => $validateData,
                'message' => 'Data pajak berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data pajak.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updatePajak(Request $request, $id)
    {
        try {
            $pajak = Pajak::findOrFail($id);

            $validateData = $request->validate([
                'tanggal_pajak' => 'required|date',
                'jenis_pajak' => 'required|string',
                'lokasi_samsat' => 'required|string',
                'biaya' => 'required|numeric',
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
                'data' => $validateData,
                'message' => 'Data pajak berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data pajak.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
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
                'data' => [],
                'message' => 'Data pajak berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data pajak.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
