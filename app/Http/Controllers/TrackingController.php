<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrackingController extends Controller
{
    public function detailTracking($id)
    {
        try {
            $dataTracking = Tracking::find($id);

            if ($dataTracking) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTracking,
                    'message' => 'Data tracking berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tracking'
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

    public function listTracking()
    {
        try {
            $dataTracking = Tracking::all();

            if ($dataTracking) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTracking,
                    'message' => 'Data tracking berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tracking'
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

    public function createTracking(Request $request)
    {
        try {
            $validateData = $request->validate([
                'koordinat' => 'required|string',
                'fk_id_mobil' => 'required|integer',
            ]);

            Tracking::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data tracking berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data tracking.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updateTracking(Request $request, $id)
    {
        try {
            $Tracking = Tracking::findOrFail($id);

            $validateData = $request->validate([
                'koordinat' => 'required|string',
                'fk_id_mobil' => 'sometimes|required|integer',
            ]);

            $Tracking->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data tracking berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data tracking.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deleteTracking($id)
    {
        try {
            $Tracking = Tracking::findOrFail($id);
            $Tracking->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data tracking berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data tracking.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
