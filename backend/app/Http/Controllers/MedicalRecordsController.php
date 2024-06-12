<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\MedicalRecords;
use App\Models\Patients;
use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class MedicalRecordsController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = MedicalRecords::with(['patient', 'doctor'])->get();

        return response(["records" => $records], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            $request->validate([

                'patients_id' => 'required|integer',
                'record' => 'required|string',
            ]);

            Log::info('Request Data:', $request->all());


            $appointment = Appointments::where('id', $request->id)->first();

            if (!$appointment) {
                return response(["message" => "Appointment not found"], 404);
            }

            if ($appointment->status !== 'booked') {
                return response(["message" => "Appointment not booked"], 400);
            }


            $appointment->update([
                'status' => 'completed',
            ]);

            $patient = Patients::where('id', $request->patients_id)->first();
            $doctor = Doctors::where('user_id', $request->user()->id)->first();
            Log::info('patient Record:', [$patient]);
            Log::info('doctor Record:', [$doctor]);
            $record = MedicalRecords::create([
                'patients_id' => $patient->id,
                'doctors_id' => $doctor->id,
                'record' => $request->record,
            ]);

            Log::info('Medical Record:', [$record]);

            DB::commit();

            return response(["record" => $record], 201);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error:', [$e->getMessage()]);
            return response(['message' => $e->getMessage()], 500);
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $patient = Patients::where('user_id', $request->user()->id)->first();
        $records = MedicalRecords::where('patients_id', $patient->id)->with(['patient', 'doctor.user'])->get();

        return response(["records" => $records], 200);

    }

    public function getDoctorsPatient(Request $request)
    {

        $doctor = Doctors::where('user_id', $request->user()->id)->first();

        if ($doctor) {
            // Fetch patients with related medical records, doctor, and user
            $patients = Patients::whereHas('medicalRecords', function ($query) use ($doctor) {
                $query->where('doctors_id', $doctor->id);
            })
                ->with([
                    'medicalRecords' => function ($query) use ($doctor) {
                        $query->where('doctors_id', $doctor->id)
                            ->with('doctor.user');
                    },
                    'user'
                ])
                ->get();

            return response()->json(["records" => $patients], 200);
        }

        return response()->json(["message" => "No records found"], 404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecords $medicalRecords)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $record = MedicalRecords::find($id);
        $request->validate([
            'record' => 'required|string',
        ]);

        $record->update($request->all());

        return response(["record" => $record], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecords $medicalRecords)
    {
        //
    }
}
