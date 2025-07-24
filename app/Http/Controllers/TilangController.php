<?php

namespace App\Http\Controllers;

use App\Models\Tilang;
use Illuminate\Http\Request;

class TilangController extends Controller
{
    public function detailTilang($id)
    {
        try {
            $dataTilang = Tilang::find($id);

            if ($dataTilang) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTilang,
                    'message' => 'Data tilang berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tilang'
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

    public function listTilang()
    {
        try {
            $dataTilang = Tilang::all();

            if ($dataTilang) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTilang,
                    'message' => 'Data tilang berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tilang'
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
                'data' => $validateData,
                'message' => 'Data tilang berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data tilang.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updateTilang(Request $request, $id)
    {
        try {
            $tilang = Tilang::findOrFail($id);

            $validateData = $request->validate([
                'tanggal_tilang' => 'required|date',
                'jenis_pelanggaran' => 'required|string',
                'keterangan' => 'required|string',
                'lokasi' => 'required|string',
                'fk_id_mobil' => 'sometimes|required|integer',
                'fk_id_pj' => 'sometimes|required|integer',
            ]);

            $tilang->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data tilang berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data tilang.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deleteTilang($id)
    {
        try {
            $tilang = Tilang::findOrFail($id);
            $tilang->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data tilang berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data tilang.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
