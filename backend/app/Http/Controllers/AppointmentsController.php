<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Patients;
use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AppointmentsController
{


    public function index()
    {
        $appointments = Appointments::with(['doctor.user', 'patient.user'])->get();
        return response(["appointments" => $appointments], 200);
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

        try {
            $request->validate([
                'doctor_id' => 'required|exists:doctors,id',
                'appointment_date' => 'required|',
            ]);

            $existingAppointment = Appointments::where('doctors_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->exists();


            if ($existingAppointment) {
                return response()->json(['error' => 'The doctor is not available at the selected time'], 409);
            }

            $patient = Patients::where('user_id', $request->user()->id)->first();

            $appointment = Appointments::create([
                'patients_id' => $patient->id,
                'doctors_id' => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'status' => 'booked',
            ]);

            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            Log::Info($e->getMessage());
            return response(['message' => $e->getMessage()], 500);
        }
    }


    public function show(Request $request)
    {
        try {
            $date = $request->query('date');
            $time = $request->query('time');

            $datetime = $date . ' ' . $time;


            $existingAppointments = Appointments::where('appointment_date', $datetime)->pluck('doctors_id');


            $allDoctors = Doctors::with('user')->get();


            $availableDoctors = $allDoctors->filter(function ($doctor) use ($existingAppointments) {

                return !$existingAppointments->contains($doctor->id);
            });

            return response([
                'date' => $datetime,
                'available_doctors' => $availableDoctors
            ], 200);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
    }

    public function showPatientAppointments(Request $request)
    {
        try {
            $id = $request->user()->id;
            $patient = Patients::where('user_id', $id)->first();
            $record = Appointments::where('patients_id', $patient->id)
                ->with(['doctor.user', 'patient.user'])
                ->get();


            return response([
                'patient_appointments' => $record
            ]);
        } catch (\Exception $e) {

            return response(['message' => $e->getMessage()], 500);
        }


    }

    public function showDoctorAppointments(Request $request)
    {

        try {

            $doctor = Doctors::where('user_id', $request->user()->id)->first();

            $record = Appointments::where('doctors_id', $doctor->id)->with(['doctor.user', 'patient.user'])->get();

            return response([
                'doctor_appointments' => $record
            ]);

        } catch (\Exception $e) {

            return response(['message' => $e->getMessage()], 500);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function cancelOwnAppointment(Request $request, $id)
    {

        try {

            $appointment = Appointments::find($id);

            if ($appointment) {
                $appointment->update([
                    'status' => 'cancelled',
                ]);
                return response([
                    'message' => 'Appointment cancelled successfully',
                    'appointment' => $appointment
                ], 200);
            }
        } catch (\Exception $e) {

            return response(['message' => $e->getMessage()], 500);
        }
    }


    public function destroy(Appointments $appointments)
    {
        //
    }
}
