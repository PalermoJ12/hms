<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patients;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PatientsController
{

    public function index()
    {
        $patients = Patients::with('user', 'appointments', 'medicalRecords.doctor.user')->get();

        return response(["patients" => $patients], 200);
    }


    public function store(Request $request)
    {

        try {
            $request->validate([
                'date_of_birth' => 'required',
                'gender' => 'required|string',
                'phone' => 'required|string',
                'address' => 'required|string',
                'user' => 'required|array',
                'user.name' => 'required|string',
                'user.email' => 'required|email|unique:users,email',
                'user.password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $request->input('user.name'),
                'email' => $request->input('user.email'),
                'password' => bcrypt($request->input('user.password')),
                'role' => 'patient'
            ]);


            $patient = Patients::create([
                'user_id' => $user->id,
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
            ]);

            $patient->load('user');
            return response(['user' => $patient], 201);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(['message' => $exception->getMessage()], 500);
        }

    }


    public function show($id)
    {

        $patient = Patients::where('user_id', $id)->with('user')->first();
        Log::info("===", [$patient]);
        return response(['patient' => $patient], 200);
    }

 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $patient = Patients::find($id);
            $request->validate([
                'user.name' => 'required|string',
                'date_of_birth' => 'required',
                'gender' => 'required|string',
                'phone' => 'required|string',
                'address' => 'required|string',
            ]);

            $user = User::find($request->user_id);
            $user->update([
                'name' => $request->input('user.name'),
            ]);


            $patient->update([
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
            DB::commit();

            return response(["patient" => $patient], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return response(['message' => $exception->getMessage()], 500);
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $patient = Patients::find($id);
        $patient->appointments()->delete();
        $patient->medicalRecords()->delete();
        $patient->user()->delete();
        $patient->delete();
    }
}
