<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;

class ServiceController extends Controller
{
    public function detailService($id)
    {
        try {
            $dataService = Service::find($id);

            if ($dataService) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataService,
                    'message' => 'Data service berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data service'
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

    public function listService()
    {
        try {
            $dataService = Service::all();

            if ($dataService) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataService,
                    'message' => 'Data service berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data service'
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

    public function createService(Request $request)
    {
        try {
            $validateData = $request->validate([
                'tanggal_ganti_service' => 'required|date',
                'keterangan' => 'required|string',
                'bengkel' => 'required|string',
                'harga' => 'required|numeric',
                'nota' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_mobil' => 'required|integer',
                'fk_id_pj' => 'required|integer',
            ]);

            // Simpan nota ke local storage
            $path = $request->file('nota')->store('nota_service', 'public');
            $validateData['nota'] = $path;

            Service::create($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data service berhasil ditambahkan.'
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
                'message' => 'Terjadi kesalahan saat menambahkan data service.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updateService(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);

            $validateData = $request->validate([
                'tanggal_ganti_service' => 'required|date',
                'keterangan' => 'required|string',
                'bengkel' => 'required|string',
                'harga' => 'required|numeric',
                'nota' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_mobil' => 'sometimes|required|integer',
                'fk_id_pj' => 'sometimes|required|integer',
            ]);

            if ($request->hasFile('nota')) {
                if ($service->nota && Storage::disk('public')->exists($service->nota)) {
                    Storage::disk('public')->delete($service->nota);
                }

                $path = $request->file('nota')->store('nota_service', 'public');
                $validateData['nota'] = $path;
            }

            $service->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data service berhasil diperbarui.'
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
                'message' => 'Terjadi kesalahan saat memperbarui data service.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deleteService($id)
    {
        try {
            $service = Service::findOrFail($id);

            if ($service->nota && Storage::disk('public')->exists($service->nota)) {
                Storage::disk('public')->delete($service->nota);
            }

            $service->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data service berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data service.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
