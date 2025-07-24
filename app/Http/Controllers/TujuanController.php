<?php

namespace App\Http\Controllers;

use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TujuanController extends Controller
{
    public function detailTujuan($id)
    {
        try {
            $dataTujuan = Tujuan::find($id);

            if ($dataTujuan) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTujuan,
                    'message' => 'Data tujuan berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tujuan'
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

    public function listTujuan()
    {
        try {
            $dataTujuan = Tujuan::all();

            if ($dataTujuan) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTujuan,
                    'message' => 'Data tujuan berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tujuan'
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

    public function createTujuan(Request $request)
    {
        try {
            $validateData = $request->validate([
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
                'tarif' => 'required|integer',
            ]);

            Tujuan::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data tujuan berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data tujuan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updateTujuan(Request $request, $id)
    {
        try {
            $tujuan = Tujuan::findOrFail($id);

            $validateData = $request->validate([
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
                'tarif' => 'required|integer',
            ]);

            $tujuan->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data tujuan berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data tujuan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deleteTujuan($id)
    {
        try {
            $tujuan = Tujuan::findOrFail($id);
            $tujuan->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data tujuan berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data tujuan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
