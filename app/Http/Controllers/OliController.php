<?php

namespace App\Http\Controllers;

use App\Models\Oli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OliController extends Controller
{
    public function detailOli($id)
    {
        try {
            $dataOli = Oli::find($id);

            if ($dataOli) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataOli,
                    'message' => 'Data oli berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data oli'
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

    public function listOli()
    {
        try {
            $dataOli = Oli::all();

            if ($dataOli) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataOli,
                    'message' => 'Data oli berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data oli'
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
                'data' => $validateData,
                'message' => 'Data oli berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data oli.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
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
                'nota' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_mobil' => 'sometimes|required|integer',
                'fk_id_pj' => 'sometimes|required|integer',
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
                'data' => $validateData,
                'message' => 'Data oli berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data oli.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
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
                'data' => [],
                'message' => 'Data oli berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data oli.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
