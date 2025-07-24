<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function detailDriver($id)
    {
        try {
            $dataDriver = Driver::find($id);

            if ($dataDriver) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataDriver,
                    'message' => 'Data driver berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data driver'
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

    public function listDriver()
    {
        try {
            $dataDriver = Driver::all();

            if ($dataDriver) {
                return response()->json([
                    'id' => '1',
                    'data' => $dataDriver,
                    'message' => 'Data driver berhasil ditemukan'
                ]);
            } else {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Tidak ada data driver'
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

    public function createDriver(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string',
                'nama_lengkap' => 'required|string',
                'alamat' => 'required|string',
                'umur' => 'required|numeric',
                'nik' => 'required|numeric',
                'sim' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                // 'fk_id_user' => 'required|integer',
            ]);

            // Simpan foto ke local storage
            $path = $request->file('foto')->store('foto_Driver', 'public');
            $validateData['foto'] = $path;

            DB::beginTransaction();
            $user = User::create([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'password' => Hash::make($validateData['password']),
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

            DB::commit();
            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data driver berhasil ditambahkan.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menambahkan data driver.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function updateDriver(Request $request, $id)
    {
        try {
            $driver = Driver::findOrFail($id);
            $user = $driver->user;

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id, 'id'),
                ],
                'password' => 'required|string',
                'nama_lengkap' => 'required|string',
                'alamat' => 'required|string',
                'umur' => 'required|numeric',
                'nik' => 'required|numeric',
                'sim' => 'required|string',
                'foto' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'id' => '0',
                    'data' => [],
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->messages()
                ], 422);
            }

            $validateData = $validator->validated();

            // Handle foto upload jika ada
            if ($request->hasFile('foto')) {
                if ($driver->foto && Storage::disk('public')->exists($driver->foto)) {
                    Storage::disk('public')->delete($driver->foto);
                }

                $path = $request->file('foto')->store('foto_Driver', 'public');
                $validateData['foto'] = $path;
            }

            DB::beginTransaction();

            // Update data User
            if ($user) {
                $userData = [
                    'name' => $validateData['name'],
                    'email' => $validateData['email'],
                    'password' => Hash::make($validateData['password']),
                ];

                $user->update($userData);
            }

            // Hapus field yang milik user, agar tidak ikut ke update Driver
            unset($validateData['name'], $validateData['email'], $validateData['password']);

            $driver->update($validateData);

            DB::commit();
            return response()->json([
                'id' => '1',
                'data' => $validateData,
                'message' => 'Data driver dan user berhasil diperbarui.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat memperbarui data driver.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }

    public function deleteDriver($id)
    {
        try {
            $Driver = Driver::findOrFail($id);
            $user = $Driver->user;

            if ($Driver->foto && Storage::disk('public')->exists($Driver->foto)) {
                Storage::disk('public')->delete($Driver->foto);
            }

            $Driver->delete();
            $user->delete();

            return response()->json([
                'id' => '1',
                'data' => [],
                'message' => 'Data driver berhasil dihapus.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'id' => '0',
                'data' => [],
                'message' => 'Terjadi kesalahan saat menghapus data driver.',
                'errors' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 500);
        }
    }
}
