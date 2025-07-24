<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function listDriver()
    {
        try {
            $dataDriver = Driver::all();

            return response()->json([
                'id' => '1',
                'data' => $dataDriver
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal mengambil data Driver.'
            ]);
        }
    }

    public function createDriver(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'nama_lengkap' => 'required|string',
                'alamat' => 'required|string',
                'umur' => 'required|numeric',
                'nik' => 'required|numeric',
                'sim' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_user' => 'required|integer',
            ]);

            // Simpan foto ke local storage
            $path = $request->file('foto')->store('foto_Driver', 'public');
            $validateData['foto'] = $path;

            $user = User::create([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'password' => $validateData['password'],
            ]);

            Driver::create([
                'nama_lengkap' => $validateData['nama_lengkap'],
                'alamat' => $validateData['alamat'],
                'umur' => $validateData['umur'],
                'nik' => $validateData['nik'],
                'sim' => $validateData['sim'],
                'foto' => $validateData['foto'],
                'fk_id_user' => $user->id,    
            ]);

            return response()->json([
                'id' => '1',
                'data' => 'Data Driver berhasil ditambahkan.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menambahkan data Driver.' . $th
            ]);
        }
    }

    public function updateDriver(Request $request, $id)
    {
        try {
            $Driver = Driver::findOrFail($id);

            $validateData = $request->validate([
                'nama_lengkap' => 'sometimes|required|string',
                'alamat' => 'sometimes|required|string',
                'umur' => 'sometimes|required|numeric',
                'nik' => 'sometimes|required|numeric',
                'sim' => 'sometimes|required|string',
                'foto' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
                'fk_id_user' => 'sometimes|required|integer',
            ]);

            if ($request->hasFile('foto')) {
                if ($Driver->foto && Storage::disk('public')->exists($Driver->foto)) {
                    Storage::disk('public')->delete($Driver->foto);
                }

                $path = $request->file('foto')->store('foto_Driver', 'public');
                $validateData['foto'] = $path;
            }

            $Driver->update($validateData);

            return response()->json([
                'id' => '1',
                'data' => 'Data Driver berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal memperbarui data Driver.'
            ]);
        }
    }

    public function deleteDriver($id)
    {
        try {
            $Driver = Driver::findOrFail($id);

            if ($Driver->foto && Storage::disk('public')->exists($Driver->foto)) {
                Storage::disk('public')->delete($Driver->foto);
            }

            $Driver->delete();

            return response()->json([
                'id' => '1',
                'data' => 'Data Driver berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => 'Gagal menghapus data Driver.'
            ]);
        }
    }
}
