<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DoctorsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctor = Doctors::with('user', 'appointments', 'medicalRecords')->get();
        return response(["doctor" => $doctor], 200);
    }

  
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            $request->validate([
                'user.name' => 'required|string',
                'specialization' => 'required|string',
                'profile' => 'required|string',
            ]);

            $user = User::create([
                'name' => $request->input('user.name'),
                'email' => $request->input('user.email'),
                'password' => bcrypt($request->input('user.password')),
                'role' => 'doctor'
            ]);

            $doctor = Doctors::create([
                'user_id' => $user->id,
                'specialization' => $request->specialization,
                'profile' => $request->profile,
            ]);

            DB::commit();

            return response(['doctor' => $doctor], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor = Doctors::where('user_id', $id)->with('user', 'appointments', 'medicalRecords')->first();
        return response(["doctor" => $doctor], 200);
    }

   
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'user.name' => 'required|string',
                'specialization' => 'required|string',
                'profile' => 'required|string',
            ]);

            $user = User::find($request->user_id);
            $user->update([
                'name' => $request->input('user.name'),
            ]);

            $doctor = Doctors::find($id);
            $doctor->update([
                'specialization' => $request->specialization,
                'profile' => $request->profile,
            ]);

            DB::commit();

            return response(['doctor' => $doctor], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctors::find($id);
        $doctor->appointments()->delete();
        $doctor->medicalRecords()->delete();
        $doctor->user()->delete();
        $doctor->delete();
    }
}
