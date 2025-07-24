<?php

namespace App\Http\Controllers;

use App\Models\Perjalanan;
use App\Models\Tujuan;
use App\Models\TujuanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TujuanPerjalananController extends Controller
{
    public function detailTujuanPerjalanan($id)
    {
        try {
            $dataTujuanPerjalanan = TujuanPerjalanan::with(['tujuan', 'perjalanan'])->find($id);

            if ($dataTujuanPerjalanan) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTujuanPerjalanan,
                    'message' => 'Data tujuan perjalanan berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tujuan perjalanan'
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

    public function listTujuanPerjalanan()
    {
        try {
            $dataTujuanPerjalanan = TujuanPerjalanan::with(['tujuan', 'perjalanan'])->get();

            if ($dataTujuanPerjalanan) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataTujuanPerjalanan,
                    'message' => 'Data tujuan perjalanan berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data tujuan perjalanan'
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

    public function createTujuanPerjalanan(Request $request)
    {
        try {
            $validateData = $request->validate([
                'fk_id_perjalanan' => 'required|integer',
                'fk_id_tujuan' => 'required|integer',
            ]);

            TujuanPerjalanan::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data tujuan perjalanan berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data tujuan perjalanan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updateTujuanPerjalanan(Request $request, $id)
    {
        try {
            $TujuanPerjalanan = TujuanPerjalanan::findOrFail($id);

            $validateData = $request->validate([
                'fk_id_perjalanan' => 'sometimes|required|integer',
                'fk_id_tujuan' => 'sometimes|required|integer',
            ]);

            $TujuanPerjalanan->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data tujuan perjalanan berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data tujuan perjalanan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deleteTujuanPerjalanan($id)
    {
        try {
            $TujuanPerjalanan = TujuanPerjalanan::findOrFail($id);
            $TujuanPerjalanan->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data tujuan perjalanan berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data tujuan perjalanan.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function createTujuanPerjalananAIO(Request $request)
    {
        try {
            $validateData = $request->validate([
                'perjalanan.waktu_berangkat' => 'required|date',
                'perjalanan.waktu_kembali' => 'required|date',
                'perjalanan.fk_id_mobil' => 'required|integer',
                'perjalanan.fk_id_pj' => 'required|integer',
                'tujuan.kota' => 'required|string',
                'tujuan.kecamatan' => 'required|string',
                'tujuan.tarif' => 'required|numeric',
            ]);

            $perjalanan = Perjalanan::create($request->input('perjalanan'));
            $tujuan = Tujuan::create($request->input('tujuan'));

            $tujuanPerjalanan = TujuanPerjalanan::create([
                'fk_id_perjalanan' => $perjalanan->id,
                'fk_id_tujuan' => $tujuan->id,
            ]);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Tujuan perjalanan berhasil dibuat beserta data perjalanan dan tujuan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updateTujuanPerjalananAIO(Request $request, $id)
    {
        try {
            $tujuanPerjalanan = TujuanPerjalanan::with(['perjalanan', 'tujuan'])->findOrFail($id);

            $validateData = $request->validate([
                'perjalanan.waktu_berangkat' => 'required|date',
                'perjalanan.waktu_kembali' => 'required|date',
                'perjalanan.fk_id_mobil' => 'required|integer',
                'perjalanan.fk_id_pj' => 'required|integer',
                'tujuan.kota' => 'required|string',
                'tujuan.kecamatan' => 'required|string',
                'tujuan.tarif' => 'required|numeric',
            ]);

            if ($request->has('perjalanan')) {
                $tujuanPerjalanan->perjalanan->update($request->input('perjalanan'));
            }

            if ($request->has('tujuan')) {
                $tujuanPerjalanan->tujuan->update($request->input('tujuan'));
            }

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Tujuan perjalanan berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deleteTujuanPerjalananAIO($id)
    {
        try {
            $tujuanPerjalanan = TujuanPerjalanan::with(['perjalanan', 'tujuan'])->findOrFail($id);

            $tujuanPerjalanan->delete();

            $tujuanPerjalanan->perjalanan->delete();
            $tujuanPerjalanan->tujuan->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data tujuan perjalanan, perjalanan, dan tujuan berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
