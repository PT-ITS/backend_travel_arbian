<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;

class ServiceController extends Controller
{
    public function listService()
    {
        try {
            $dataService = Service::all();

            return response()->json([
                'id' => '1',
                'data' => $dataService
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data service.'
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
                'data' => 'Data service berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data service.'
            ]);
        }
    }

    public function updateService(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);

            $validateData = $request->validate([
                'tanggal_ganti_service' => 'sometimes|required|date',
                'keterangan' => 'sometimes|required|string',
                'bengkel' => 'sometimes|required|string',
                'harga' => 'sometimes|required|numeric',
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
                'data' => 'Data service berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data service.'
            ]);
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
                'data' => 'Data service berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data service.'
            ]);
        }
    }
}
