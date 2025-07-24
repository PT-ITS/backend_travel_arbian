<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrackingController extends Controller
{
    public function listTracking()
    {
        try {
            $dataTracking = Tracking::all();

            return response()->json([
                'id' => '1',
                'data' => $dataTracking
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data Tracking.'
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
                'data' => 'Data Tracking berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data Tracking.'
            ]);
        }
    }

    public function updateTracking(Request $request, $id)
    {
        try {
            $Tracking = Tracking::findOrFail($id);

            $validateData = $request->validate([
                'koordinat' => 'sometimes|required|string',
                'fk_id_mobil' => 'sometimes|required|integer',
            ]);

            $Tracking->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data Tracking berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data Tracking.'
            ]);
        }
    }

    public function deleteTracking($id)
    {
        try {
            $Tracking = Tracking::findOrFail($id);
            $Tracking->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data Tracking berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data Tracking.'
            ]);
        }
    }
}
