<?php

namespace App\Http\Controllers;

use App\Models\Perjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerjalananController extends Controller
{
    public function detailPerjalanan($id)
    {
        try {
            $dataPerjalanan = Perjalanan::find($id);

            if ($dataPerjalanan) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataPerjalanan,
                    'message' => 'Data perjalanan berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data perjalanan'
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

    public function listPerjalanan()
    {
        try {
            $dataPerjalanan = Perjalanan::all();

            if ($dataPerjalanan) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataPerjalanan,
                    'message' => 'Data perjalanan berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data perjalanan'
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
                'data' => $validateData,
                'message' => 'Data perjalanan berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data perjalanan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updatePerjalanan(Request $request, $id)
    {
        try {
            $Perjalanan = Perjalanan::findOrFail($id);

            $validateData = $request->validate([
                'waktu_berangkat' => 'required',
                'waktu_kembali' => 'required',
                'fk_id_mobil' => 'sometimes|required|integer',
                'fk_id_pj' => 'sometimes|required|integer',
            ]);

            $Perjalanan->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data perjalanan berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data perjalanan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deletePerjalanan($id)
    {
        try {
            $Perjalanan = Perjalanan::findOrFail($id);
            $Perjalanan->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data perjalanan berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data perjalanan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
